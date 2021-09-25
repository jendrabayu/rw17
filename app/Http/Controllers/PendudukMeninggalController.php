<?php

namespace App\Http\Controllers;

use App\DataTables\PendudukMeninggalDataTable;
use App\Exports\PendudukMeninggalExport;
use App\Http\Requests\PendudukMeninggal\PendudukMeninggalStoreRequest;
use App\Http\Requests\PendudukMeninggal\PendudukMeninggalUpdateRequest;
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
    public function index(Request $request, PendudukMeninggalDataTable $pendudukMeninggalDataTable)
    {
        $user = auth()->user();

        if ($user->hasRole('rt')) {
            $penduduk = Penduduk::whereHas('keluarga', function ($q) use ($user) {
                return $q->where('rt_id', $user->rt->id);
            })->get();
            $rt = $user->rt;
        }

        if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
            $penduduk = null;
        }

        $fileTypes = PendudukMeninggal::FILE_TYPES;

        return $pendudukMeninggalDataTable->render('penduduk-meninggal.index', compact('rt', 'penduduk', 'fileTypes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PendudukMeninggalStoreRequest $request)
    {
        $request->validated();

        try {
            DB::beginTransaction();
            $penduduk = Penduduk::findOrFail($request->penduduk_id);
            $data = array_merge($request->all(), $penduduk->toArray(), ['alamat' => $penduduk->keluarga->alamat]);
            PendudukMeninggal::create($data);
            $penduduk->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors($exception->getMessage())->withInput();
        }

        return back()->withSuccess('Berhasil menambahkan penduduk meninggal');
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

        if ($user->hasRole('rt') && $user->rt_id !== $pendudukMeninggal->rt_id) {
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

        if ($user->hasRole('rt') && $user->rt_id !== $pendudukMeninggal->rt_id) {
            abort(404);
        }

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        }

        if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
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
    public function update(PendudukMeninggalUpdateRequest $request, PendudukMeninggal $pendudukMeninggal)
    {
        $validated = $request->validated();
        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            Storage::disk('public')->delete($pendudukMeninggal->foto_ktp);
        }

        $pendudukMeninggal->update($validated);

        return back()->withSuccess('Penduduk meninggal berhasil diupdate');
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

        return response()->json(['success' => true], 204);
    }

    public function export(Request $request)
    {
        if (is_null($request->file_type) || !in_array($request->file_type, PendudukMeninggal::FILE_TYPES)) {
            return back()->withError('Tipe file harus ' . join(',', PendudukMeninggal::FILE_TYPES));
        }

        $user = auth()->user();
        $pendudukMeninggal = PendudukMeninggal::with([
            'rt.rw',
            'darah',
            'agama',
            'statusPerkawinan',
            'pekerjaan',
            'pendidikan'
        ]);

        if ($user->hasRole('rt')) {
            $pendudukMeninggal->whereRtId($user->rt_id);
            $filename = 'Penduduk_Meninggal_RT_' . $user->rt->nomor;
        }

        if ($user->hasRole('rw')) {
            $pendudukMeninggal
                ->whereHas('rt', function ($q) use ($user) {
                    return $q->whereRwId($user->rt->rw_id);
                })
                ->when($request->has('rt'), function ($q) use ($request) {
                    return $q->whereRtId($request->rt);
                });

            if ($request->has('rt')) {
                $noRt = Rt::where('id', $request->rt)->firstOrFail()->nomor;
                $filename = 'Penduduk_Meninggal_RT_' . $noRt;
            } else {
                $filename = 'Penduduk_Meninggal';
            }
        }

        $pendudukMeninggal = $pendudukMeninggal->latest()->get();
        $filename = "{$filename}.{$request->file_type}";


        return Excel::download(new PendudukMeninggalExport($pendudukMeninggal), $filename);
    }
}
