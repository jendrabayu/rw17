<?php

namespace App\Http\Controllers;

use App\DataTables\KeluargaDataTable;
use App\Events\LogUserActivity;
use App\Exports\KeluargaExport;
use App\Http\Requests\Keluarga\KeluargaStoreRequest;
use App\Http\Requests\Keluarga\KeluargaUpdateRequest;
use App\Models\Keluarga;
use App\Models\Rt;
use App\Models\Rumah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KeluargaDataTable $keluargaDataTable)
    {
        return $keluargaDataTable->render('keluarga.index', [
            'fileTypes' => Keluarga::FILE_TYPES,
            'rt' => auth()->user()->rt->rw->rt->pluck('nomor', 'id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keluarga.create', [
            'rt' => auth()->user()->rt,
            'rumah' => auth()->user()->rt->rumah->pluck('alamat', 'id')
        ]);
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
        $keluarga = Keluarga::create($validated);
        $keluarga->rumah()->attach($request->rumah_id);
        event(new LogUserActivity("Tambah Keluarga $keluarga->nomor", __CLASS__));

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
        abort_if($user->hasRole('rt') && $keluarga->rt_id !== $user->rt_id, 404);

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
        event(new LogUserActivity("Lihat Detail Keluarga $keluarga->nomor", __CLASS__));

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
        abort_if($user->hasRole('rt') && $keluarga->rt_id !== $user->rt_id, 404);

        return view('keluarga.edit', [
            'keluarga' => $keluarga,
            'rt' => $user->rt,
            'rumah' => $user->rt->rumah->pluck('alamat', 'id')
        ]);
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
        $keluarga->rumah()->sync($request->rumah_id);
        event(new LogUserActivity("Update Keluarga $keluarga->nomor", __CLASS__));

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
        event(new LogUserActivity("Hapus Keluarga $keluarga->nomor", __CLASS__));

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

        if ($user->hasRole(['admin', 'rw'])) {
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
        event(new LogUserActivity("Export Keluarga $filename", __CLASS__));

        return Excel::download(new KeluargaExport($keluarga), $filename);
    }
}
