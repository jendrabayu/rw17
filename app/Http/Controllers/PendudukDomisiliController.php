<?php

namespace App\Http\Controllers;

use App\Exports\PendudukDomisiliExport;
use App\Http\Requests\PendudukDomisili\StorePendudukDomisiliRequest;
use App\Http\Requests\PendudukDomisili\UpdatePendudukDomisiliRequest;
use App\Models\Agama;
use App\Models\Darah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PendudukDomisili;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PendudukDomisiliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $pendudukDomisili = PendudukDomisili::query();

        if ($user->hasRole('rt')) {
            $pendudukDomisili->where('rt_id', $user->rt->id)->get();
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $pendudukDomisili->when($request->has('rt'), function ($q) use ($request) {
                return $q->where('rt_id', $request->get('rt'));
            });
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        } else {
            abort(403);
        }

        $pendudukDomisili = $pendudukDomisili->latest()->get();

        return view('penduduk-domisili.index', compact('pendudukDomisili', 'rt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

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

        return view('penduduk-domisili.create', compact(
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePendudukDomisiliRequest $request)
    {
        $validated = $request->validated();

        if ($request->file('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        PendudukDomisili::create($validated);

        return back()->with('success', 'Berhasil menambahkan penduduk domisili');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PendudukDomisili $pendudukDomisili)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $pendudukDomisili->rt->sid !== $user->rt->id) {
            abort(404);
        }

        return view('penduduk-domisili.show', compact('pendudukDomisili'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PendudukDomisili $pendudukDomisili)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $pendudukDomisili->rt->id !== $user->rt->id) {
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

        return view('penduduk-domisili.edit', compact(
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
            'pendudukDomisili'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePendudukDomisiliRequest $request, PendudukDomisili $penduduk_domisili)
    {
        $validated = $request->validated();

        if ($request->file('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            Storage::disk('public')->delete($penduduk_domisili->foto_ktp);
        }

        $penduduk_domisili->update($validated);

        return back()->with('success', 'Penduduk domisili berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendudukDomisili $pendudukDomisili)
    {
        Storage::disk('public')->delete($pendudukDomisili->foto_ktp);
        $pendudukDomisili->delete();

        return back()->with('success', 'Berhasil menghapus penduduk domisili');
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $pendudukDomisili = PendudukDomisili::query();

        if ($user->hasRole('rt')) {
            $pendudukDomisili->where('rt_id', $user->rt->id);
            $fileName = 'Penduduk_Domisili_RT_' . $user->rt->nomor;
        } else if ($user->hasRole('rw')) {
            $pendudukDomisili->whereHas('rt', function ($q) use ($user) {
                return $q->where('rw_id', $user->rt->rw->id);
            })->when($request->has('rt'), function ($q) use ($request) {
                return $q->where('rt_id', $request->get('rt'));
            });
            $fileName = $request->has('rt') ? 'Penduduk_Domisili_RT_' . Rt::where('id', $request->get('rt'))->first()->nomor : 'Penduduk_Domisili';
        } else {
            abort(403);
        }

        $pendudukDomisili = $pendudukDomisili->latest()->get();

        return Excel::download(new PendudukDomisiliExport($pendudukDomisili), $fileName . '.' . strtolower($request->get('format')));
    }
}
