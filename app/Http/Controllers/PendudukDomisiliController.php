<?php

namespace App\Http\Controllers;

use App\DataTables\PendudukDomisiliDataTable;
use App\Events\LogUserActivity;
use App\Exports\PendudukDomisiliExport;
use App\Http\Requests\PendudukDomisili\PendudukDomisiliStoreRequest;
use App\Http\Requests\PendudukDomisili\PendudukDomisiliUpdateRequest;
use App\Models\Agama;
use App\Models\Darah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PendudukDomisili;
use App\Models\Rt;
use App\Models\Rumah;
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
    public function index(PendudukDomisiliDataTable $pendudukDomisiliDataTable)
    {
        return $pendudukDomisiliDataTable->render('penduduk-domisili.index', [
            'rt' =>  auth()->user()->rt->rw->rt->pluck('nomor', 'id'),
            'fileTypes' => PendudukDomisili::FILE_TYPES
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rt = auth()->user()->rt;
        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');
        $rumah = $rt->rumah->pluck('alamat', 'id');

        return view('penduduk-domisili.create', compact(
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
            'rumah'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PendudukDomisiliStoreRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $pendudukDomisili = PendudukDomisili::create($validated);
        event(new LogUserActivity("Tambah Penduduk Domisili $pendudukDomisili->nama [$pendudukDomisili->nik]", __CLASS__));

        return back()->withSuccess('Berhasil menambahkan penduduk domisili');
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
        abort_if($user->hasRole('rt') && $pendudukDomisili->rt_id !== $user->rt_id, 404);
        event(new LogUserActivity("Lihat Detail Penduduk Domisili $pendudukDomisili->nama [$pendudukDomisili->nik]", __CLASS__));

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
        abort_if($user->hasRole('rt') && $pendudukDomisili->rt_id !== $user->rt_id, 404);

        $rt = $user->rt;
        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');
        $rumah = $rt->rumah->pluck('alamat', 'id');

        return view('penduduk-domisili.edit', compact(
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
            'pendudukDomisili',
            'rumah'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PendudukDomisiliUpdateRequest $request, PendudukDomisili $pendudukDomisili)
    {
        $validated = $request->validated();
        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            Storage::disk('public')->delete($pendudukDomisili->foto_ktp);
        }

        $pendudukDomisili->update($validated);
        event(new LogUserActivity("Update Penduduk Domisili $pendudukDomisili->nama [$pendudukDomisili->nik]", __CLASS__));


        return back()->withSuccess('Penduduk domisili berhasil diupdate');
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
        event(new LogUserActivity("Hapus Penduduk Domisili $pendudukDomisili->nama [$pendudukDomisili->nik]", __CLASS__));
        $pendudukDomisili->delete();

        return response()->json(['success' => true], 204);
    }

    public function export(Request $request)
    {
        if (is_null($request->file_type) || !in_array($request->file_type, PendudukDomisili::FILE_TYPES)) {
            return back()->withError('Tipe file harus ' . join(',', PendudukDomisili::FILE_TYPES));
        }

        $user = auth()->user();
        $pendudukDomisili = PendudukDomisili::with([
            'agama',
            'darah',
            'pekerjaan',
            'pendidikan',
            'statusPerkawinan',
            'rt.rw'
        ]);

        if ($user->hasRole('rt')) {
            $pendudukDomisili->whereRtId($user->rt_id);
            $filename = 'Penduduk_Domisili_RT_' . $user->rt->nomor;
        }

        if ($user->hasRole(['admin', 'rw'])) {
            $pendudukDomisili
                ->whereHas('rt', function ($q) use ($user) {
                    return $q->whereRwId($user->rt->rw_id);
                })
                ->when($request->has('rt'), function ($q) use ($request) {
                    return $q->whereRtId($request->rt);
                });

            if ($request->has('rt')) {
                $noRt = Rt::where('id', $request->rt)->firstOrFail()->nomor;
                $filename = 'Penduduk_Domisili_RT_' . $noRt;
            } else {
                $filename = 'Penduduk_Domisili';
            }
        }

        $pendudukDomisili = $pendudukDomisili->latest()->get();
        $filename = "{$filename}.{$request->file_type}";
        event(new LogUserActivity("Export Penduduk Domisili $filename", __CLASS__));

        return Excel::download(new PendudukDomisiliExport($pendudukDomisili), $filename);
    }
}
