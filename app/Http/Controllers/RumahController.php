<?php

namespace App\Http\Controllers;

use App\Exports\RumahExport;
use App\Http\Requests\Rumah\StoreRumahRequest;
use App\Http\Requests\Rumah\UpdateRumahRequest;
use App\Models\Rt;
use App\Models\Rumah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $rumah = Rumah::query();

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
            $rumah->where('rt_id', $user->rt->id);
        } else if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
            $rumah->when($request->has('rt'), function ($q) use ($request) {
                $q->where('rt_id', $request->get('rt'));
            });
        } else {
            abort(403);
        }

        $rumah = $rumah->orderBy('nomor')->get();
        return view('rumah.index', compact('rt', 'rumah'));
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
        } else if ($user->hasRole('rw')) {
            $rt = Rt::where('rw_id', $user->rt->rw->id)->get()->pluck('nomor', 'id');
            $keluarga = [];
        } else {
            abort(403);
        }

        return view('rumah.create', compact('rt', 'keluarga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRumahRequest $request)
    {
        $validated = $request->validated();

        $rumah = Rumah::create($validated);
        $rumah->keluarga()->attach($request->get('keluarga_id'));

        return back()->with('success', 'Berhasil menambahkan rumah');
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

        if ($user->hasRole('rt') && $rumah->rt->id !== $user->rt->id) {
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

        if ($user->hasRole('rt') && $rumah->rt->id !== $user->rt->id) {
            abort(404);
        }

        if ($user->hasRole('rt')) {
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        } else {
            abort(403);
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
    public function update(UpdateRumahRequest $request, Rumah $rumah)
    {
        $validated = $request->validated();
        $rumah->update($validated);
        $rumah->keluarga()->sync($request->get('keluarga_id'));

        return back()->with('success', 'Rumah berhasil diupdate');
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
        return back()->with('success', 'Rumah berhasil dihapus');
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $rumah = Rumah::query();

        if ($user->hasRole('rt')) {
            $rumah->where('rt_id', $user->rt->id);
        } else if ($user->hasRole('rw')) {
            $rumah->when($request->has('rt'), function ($q) use ($request) {
                $q->where('rt_id', $request->get('rt'));
            });
        } else {
            abort(403);
        }

        $rumah = $rumah->orderBy('nomor')->get();
        return Excel::download(new RumahExport($rumah), 'rumah.' . strtolower($request->get('format')));
    }
}
