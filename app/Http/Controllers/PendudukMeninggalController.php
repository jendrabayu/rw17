<?php

namespace App\Http\Controllers;

use App\Exports\PendudukMeninggalExport;
use App\Http\Requests\PendudukMeninggal\StorePendudukMeninggalRequest;
use App\Http\Requests\PendudukMeninggal\UpdatePendudukMeninggalRequest;
use App\Models\Agama;
use App\Models\Darah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\PendudukMeninggal;
use App\Models\Rt;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PendudukMeninggalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $pendudukMeninggal = PendudukMeninggal::query();

        if ($user->hasRole('rt')) {
            $penduduk = Penduduk::whereHas('keluarga', function ($q) use ($user) {
                return $q->where('rt_id', $user->rt->id);
            })->get();
            $rt = $user->rt;
            $pendudukMeninggal->where('rt_id', $user->rt->id);
        } else if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
            $penduduk = null;
            $pendudukMeninggal->when($request->has('rt'), function ($q) use ($request) {
                return $q->where('rt_id', $request->get('rt'));
            });
        } else {
            abort(403);
        }

        $pendudukMeninggal = $pendudukMeninggal->latest()->get();

        return view('penduduk-meninggal.index', compact('rt', 'penduduk', 'pendudukMeninggal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePendudukMeninggalRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            $penduduk = Penduduk::findOrFail($request->get('penduduk_id'));
            $data = array_merge($request->all(), $penduduk->toArray(), ['alamat' => $penduduk->keluarga->alamat]);
            PendudukMeninggal::create($data);
            $penduduk->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Berhasil menambahkan penduduk meninggal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PendudukMeninggal $pendudukMeninggal)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $user->rt->id !== $pendudukMeninggal->rt->id) {
            abort(404);
        }

        return view('penduduk-meninggal.show', compact('pendudukMeninggal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PendudukMeninggal $pendudukMeninggal)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $user->rt->id !== $pendudukMeninggal->rt->id) {
            abort(404);
        }

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        } else {
            abort(403);
        }

        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');

        return view('penduduk-meninggal.edit', compact(
            'pendudukMeninggal',
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePendudukMeninggalRequest $request, PendudukMeninggal $penduduk_meninggal)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            Storage::disk('public')->delete($penduduk_meninggal->foto_ktp);
        }

        $penduduk_meninggal->update($validated);
        return back()->with('success', 'Penduduk meninggal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendudukMeninggal $pendudukMeninggal)
    {
        Storage::disk('public')->delete($pendudukMeninggal->foto_ktp);
        $pendudukMeninggal->delete();

        return back()->with('success', 'Berhasil menghapus penduduk meninggal');
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $pendudukMeninggal = PendudukMeninggal::query();

        if ($user->hasRole('rt')) {
            $pendudukMeninggal->where('rt_id', $user->rt->id);
            $fileName = 'Penduduk_Meninggal_RT_' . $user->rt->nomor;
        } else if ($user->hasRole('rw')) {
            $pendudukMeninggal->whereHas('rt', function ($q) use ($user) {
                return $q->where('rw_id', $user->rt->rw->id);
            })
                ->when($request->has('rt'), function ($q) use ($request) {
                    return $q->where('rt_id', $request->get('rt'));
                });
            $fileName = $request->has('rt') ? 'Penduduk_Meninggal_RT_' . Rt::where('id', $request->get('rt'))->first()->nomor : 'Penduduk_Meninggal';
        } else {
            abort(403);
        }

        $pendudukMeninggal = $pendudukMeninggal->latest()->get();

        return Excel::download(new PendudukMeninggalExport($pendudukMeninggal), $fileName . '.' . strtolower($request->get('format')));
    }
}
