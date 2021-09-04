<?php

namespace App\Http\Controllers;

use App\Exports\KeluargaExport;
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
    public function index(Request $request)
    {
        $user = auth()->user();
        $keluarga = Keluarga::with('penduduk');

        if ($user->hasRole('rt')) {
            $keluarga->where('rt_id', $user->rt->id);
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $keluarga->when($request->has('rt'), function ($q) use ($request) {
                return $q->where('rt_id', $request->get('rt'));
            });
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        } else {
            abort(403);
        }

        $keluarga = $keluarga->latest()->get();

        return view('keluarga.index', compact('keluarga', 'rt'));
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

        return view('keluarga.create', compact('rt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'nomor' => ['numeric', 'required', 'digits:16', 'starts_with:3509', 'unique:keluarga,nomor'],
            'alamat' => ['string', 'required', 'max:200'],
            'foto_kk' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000']
        ]);

        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('kartu_keluarga', 'public');
        }

        Keluarga::create($validated);

        return back()->with('success', 'Berhasil menambahkan keluarga');
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

        if ($user->hasRole('rt') && $keluarga->rt->id !== $user->rt->id) {
            abort(404);
        }

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

        if ($user->hasRole('rt') && $keluarga->rt->id !== $user->rt->id) {
            abort(404);
        }

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        } else {
            abort(404);
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
    public function update(Request $request, $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $validated = $this->validate($request, [
            'rt_id' => ['numeric', 'required', 'exists:rt,id'],
            'nomor' => ['numeric', 'required', 'digits:16', 'starts_with:3509', 'unique:keluarga,nomor,' . $keluarga->id],
            'alamat' => ['string', 'required', 'max:200'],
            'foto_kk' => ['mimes:jpg,jpeg,png', 'nullable', 'max:1000']
        ]);

        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('kartu_keluarga', 'public');
            Storage::disk('public')->delete($keluarga->foto_ktp);
        }

        $keluarga->update($validated);

        return back()->with('success', 'Keluarga berhasil diupdate');
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

        return back()->with('success', 'Keluarga berhasil dihapus');
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $keluarga = Keluarga::with('penduduk');

        if ($user->hasRole('rt')) {
            $keluarga->where('rt_id', $user->rt->id);
            $fileName = 'Keluarga_RT_' . $user->rt->nomor;
        } else if ($user->hasRole('rw')) {
            $keluarga->when($request->has('rt'), function ($q) use ($request) {
                return $q->where('rt_id', $request->get('rt'));
            });
            $fileName = $request->has('rt') ? 'Keluarga_RT_' . Rt::where('id', $request->get('rt'))->first()->nomor : 'Keluarga';
        } else {
            abort(404);
        }

        $keluarga = $keluarga->latest()->get();

        return Excel::download(new KeluargaExport($keluarga), $fileName . '.' . strtolower($request->get('format')));
    }
}
