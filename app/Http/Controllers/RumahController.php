<?php

namespace App\Http\Controllers;

use App\Exports\RumahExport;
use App\Http\Requests\Rumah\RumahStoreRequest;
use App\Http\Requests\Rumah\RumahUpdateRequest;
use App\Models\Rt;
use App\Models\Rumah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RumahController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $rumah = Rumah::with(['keluarga']);

        if ($user->hasRole('rt')) {
            $rumah->whereRtId($user->rt_id);
            $rt = $user->rt;
        }

        if ($user->hasRole('rw')) {
            $rumah->when($request->has('rt'), function ($q) use ($request) {
                $q->whereRtId($request->rt);
            });
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        }

        $rumah = $rumah->orderBy('nomor')->get();
        $fileTypes = Rumah::FILE_TYPES;

        return view('rumah.index', compact('rt', 'rumah', 'fileTypes'));
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
            $keluarga = $user->rt->keluarga->pluck('nomor', 'id');
        }

        if ($user->hasRole('rw')) {
            $rt =  $user->rt->rw->rt->pluck('nomor', 'id');
            $keluarga = [];
        }

        return view('rumah.create', compact('rt', 'keluarga'));
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

        $rumah = Rumah::create($validated);
        $rumah->keluarga()->attach($request->keluarga_id);

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
            abort(404);
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

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        }

        if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        }

        return view('rumah.edit', compact('rumah', 'rt', 'user'));
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
        $rumah->update($validated);
        $rumah->keluarga()->sync($request->get('keluarga_id'));

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
        $rumah->delete();
        return back()->withSuccess('Rumah berhasil dihapus');
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

        if ($user->hasRole('rw')) {
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
