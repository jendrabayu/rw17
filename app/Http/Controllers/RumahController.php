<?php

namespace App\Http\Controllers;

use App\DataTables\RumahDataTable;
use App\Exports\RumahExport;
use App\Http\Requests\Rumah\RumahStoreRequest;
use App\Http\Requests\Rumah\RumahUpdateRequest;
use App\Models\PendudukDomisili;
use App\Models\PenggunaanBangunan;
use App\Models\Rt;
use App\Models\Rumah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RumahController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RumahDataTable $rumahDataTable)
    {
        return $rumahDataTable->render('rumah.index', [
            'fileTypes' => Rumah::FILE_TYPES,
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
        $user = auth()->user();
        $rt = $user->rt;
        $keluarga = $user->rt->keluarga()->doesntHave('rumah')->pluck('nomor', 'id');
        $pendudukDomisili = $user->rt
            ->pendudukDomisili()
            ->whereNull('rumah_id')
            ->get()
            ->map(function ($item) {
                $item->nama = "{$item->nik} | {$item->nama}";
                return $item;
            })
            ->pluck('nama', 'id');
        $penggunaanBangunan = PenggunaanBangunan::all()->pluck('nama', 'id');

        return view('rumah.create', compact('rt', 'keluarga', 'pendudukDomisili', 'penggunaanBangunan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RumahStoreRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $rumah = Rumah::create($validated);

            if ($request->filled('keluarga_id')) {
                $rumah->keluarga()->attach($request->keluarga_id);
            }

            if ($request->filled('penduduk_domisili_id')) {
                foreach ($request->penduduk_domisili_id as $id) {
                    $pendudukDomisili = PendudukDomisili::find($id);
                    $pendudukDomisili->rumah_id = $rumah->id;
                    $pendudukDomisili->save();
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }

        return back()->withSuccess('Berhasil menambahkan rumah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rumah $rumah)
    {
        $user = auth()->user();
        if ($user->hasRole('rt') && $rumah->rt_id !== $user->rt_id) {
            abort(403);
        }

        return view('rumah.show', compact('rumah'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rumah $rumah)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $rumah->rt_id !== $user->rt_id) {
            abort(404);
        }

        $rt = $user->rt;
        $keluarga = $user->rt->keluarga()
            ->doesntHave('rumah')
            ->get()
            ->merge($rumah->keluarga)
            ->pluck('nomor', 'id');
        $penggunaanBangunan = PenggunaanBangunan::all()->pluck('nama', 'id');
        $pendudukDomisili = $user->rt
            ->pendudukDomisili()
            ->whereNull('rumah_id')
            ->get()
            ->merge($rumah->pendudukDomisili)
            ->map(function ($item) {
                $item->nama = "$item->nik | $item->nama";
                return $item;
            })
            ->pluck('nama', 'id');

        return view('rumah.edit', compact('rumah', 'rt', 'keluarga', 'penggunaanBangunan', 'pendudukDomisili'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RumahUpdateRequest $request, Rumah $rumah)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $rumah->update($validated);
            $rumah->keluarga()->sync($request->get('keluarga_id'));

            foreach ($rumah->pendudukDomisili as $pendudukDomisili) {
                $pendudukDomisili->rumah_id = null;
                $pendudukDomisili->save();
            }

            foreach ($request->penduduk_domisili_id as $id) {
                $pendudukDomisili = PendudukDomisili::find($id);
                $pendudukDomisili->rumah_id = $rumah->id;
                $pendudukDomisili->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        return back()->withSuccess('Rumah berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rumah $rumah)
    {
        foreach ($rumah->pendudukDomisili as $pendudukDomisili) {
            $pendudukDomisili->rumah_id = null;
            $pendudukDomisili->save();
        }
        $rumah->delete();
        return response()->json(['success' => true], 204);
    }

    public function export(Request $request)
    {
        if (is_null($request->file_type) || !in_array($request->file_type, Rumah::FILE_TYPES)) {
            return back()->withError('Tipe file harus ' . join(',', Rumah::FILE_TYPES));
        }

        $user = auth()->user();
        $rumah = Rumah::with([
            'rt.rw'
        ]);

        if ($user->hasRole('rt')) {
            $rumah->whereRtId($user->rt_id);
            $filename = 'Rumah_RT_' . $user->rt->nomor;
        }

        if ($user->hasRole(['admin', 'rw'])) {
            $rumah->when($request->has('rt'), function ($q) use ($request) {
                $q->whereRtId($request->rt);
            });

            if ($request->has('rt')) {
                $noRt = Rt::where('id', $request->rt)->firstOrFail()->nomor;
                $filename = 'Rumah_RT_' . $noRt;
            } else {
                $filename = 'Rumah';
            }
        }

        $rumah = $rumah->orderBy('nomor')->get();
        $filename = "{$filename}.{$request->file_type}";

        return Excel::download(new RumahExport($rumah), $filename);
    }
}
