<?php

namespace App\Http\Controllers;

use App\DataTables\KeluargaDataTable;
use App\Exports\KeluargaExport;
use App\Http\Requests\Keluarga\KeluargaStoreRequest;
use App\Http\Requests\Keluarga\KeluargaUpdateRequest;
use App\Models\Keluarga;
use App\Models\Rt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, KeluargaDataTable $keluargaDataTable)
    {
        $user = auth()->user();

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        }

        if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        }

        $fileTypes = Keluarga::FILE_TYPES;

        return $keluargaDataTable->render('keluarga.index', compact('rt', 'fileTypes'));
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
        }

        if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        }

        return view('keluarga.create', compact('rt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeluargaStoreRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('kartu_keluarga', 'public');
        }

        Keluarga::create($validated);

        return back()->withSuccess('Berhasil menambahkan keluarga');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Keluarga $keluarga)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $keluarga->rt_id !== $user->rt_id) {
            abort(404);
        }

        $keluarga->load([
            'penduduk.statusHubunganDalamKeluarga',
            'penduduk.agama',
            'penduduk.darah',
            'penduduk.pekerjaan',
            'penduduk.pendidikan',
            'penduduk.statusPerkawinan',
        ]);

        $keluarga->kepala_keluarga = $keluarga
            ->penduduk
            ->where('statusHubunganDalamKeluarga.nama', 'KEPALA KELUARGA')
            ->first();

        return view('keluarga.show', compact('keluarga'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Keluarga $keluarga)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $keluarga->rt_id !== $user->rt_id) {
            abort(404);
        }

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        }

        if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        }

        return view('keluarga.edit', compact('keluarga', 'rt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KeluargaUpdateRequest $request, Keluarga $keluarga)
    {
        $validated = $request->validated();
        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('kartu_keluarga', 'public');
            Storage::disk('public')->delete($keluarga->foto_ktp);
        }

        $keluarga->update($validated);

        return back()->withSuccess('Keluarga berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keluarga $keluarga)
    {
        Storage::disk('public')->delete($keluarga->foto_kk);
        $keluarga->delete();

        return response()->json(['success' => true], 204);
    }

    public function export(Request $request)
    {
        if (is_null($request->file_type) || !in_array($request->file_type, Keluarga::FILE_TYPES)) {
            return back()->withError('Tipe file harus ' . join(',', Keluarga::FILE_TYPES));
        }

        $user = auth()->user();
        $keluarga = Keluarga::with(['penduduk.statusHubunganDalamKeluarga', 'rt.rw']);

        if ($user->hasRole('rt')) {
            $keluarga->whereRtId($user->rt->id);
            $filename = 'Keluarga_RT_' . $user->rt->nomor;
        }

        if ($user->hasRole('rw')) {
            $keluarga->when($request->has('rt'), function ($q) {
                return $q->whereRtId(request()->get('rt'));
            });

            if ($request->has('rt')) {
                $noRt = Rt::where('id', $request->rt)->firstOrFail()->nomor;
                $filename = 'Keluarga_RT_' . $noRt;
            } else {
                $filename =  'Keluarga';
            }
        }

        $keluarga = $keluarga->latest()->get()->map(function ($keluarga) {
            $keluarga->kepala_keluarga = $keluarga
                ->penduduk
                ->where('statusHubunganDalamKeluarga.nama', 'KEPALA KELUARGA')
                ->first();
            return $keluarga;
        });

        $filename = "{$filename}.{$request->file_type}";

        return Excel::download(new KeluargaExport($keluarga), $filename);
    }
}
