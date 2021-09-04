<?php

namespace App\Http\Controllers;

use App\Exports\PendudukExport;
use App\Http\Requests\Penduduk\StorePendudukRequest;
use App\Http\Requests\Penduduk\UpdatePendudukRequest;
use App\Models\Agama;
use App\Models\Darah;
use App\Models\Keluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\Rt;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PendudukController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $penduduk = $this->filter($request);

        if ($user->hasRole('rt')) {
            $penduduk = $penduduk
                ->whereHas('keluarga', function ($q) use ($user) {
                    $q->where('rt_id', $user->id);
                });

            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $penduduk = $penduduk
                ->whereHas('keluarga.rt', function ($q) use ($user) {
                    $q->where('rw_id', $user->rt->rw->id);
                })
                ->when($request->has('rt'), function ($q) use ($request) {
                    $q->whereHas('keluarga.rt', function ($q) use ($request) {
                        $q->where('id', $request->get('rt'));
                    });
                });

            $rt = $user->rt->rw->rt->pluck('nomor', 'id');
        } else {
            abort(403);
        }

        $penduduk = $penduduk->orderBy('keluarga_id', 'asc')->get();
        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');

        return view('penduduk.index', compact(
            'penduduk',
            'user',
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('rt')) {
            $keluarga = Keluarga::where('rt_id', $user->rt->id)->get()->pluck('nomor', 'id');
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $keluarga = Keluarga::whereHas('rt', function ($q) use ($user) {
                $q->where('rw_id', $user->rt->rw->id);
            })->get()->pluck('nomor', 'id');

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

        return view('penduduk.create', compact(
            'keluarga',
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
    public function store(StorePendudukRequest $request)
    {
        $validated = $request->validated();

        if ($request->file('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        Penduduk::create($validated);

        return back()->with('success', 'Berhasil menambahkan penduduk');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Penduduk $penduduk)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $penduduk->keluarga->rt->id !== $user->rt->id) {
            abort(404);
        }

        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Penduduk $penduduk)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $penduduk->keluarga->rt->id !== $user->rt->id) {
            abort(404);
        }

        if ($user->hasRole('rt')) {
            $keluarga = Keluarga::where('rt_id', $user->rt->id)->get()->pluck('nomor', 'id');
            $rt = $user->rt;
        } else if ($user->hasRole('rw')) {
            $keluarga = Keluarga::whereHas('rt', function ($q) use ($user) {
                $q->where('rw_id', $user->rt->rw->id);
            })->get()->pluck('nomor', 'id');

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

        return view('penduduk.edit', compact(
            'keluarga',
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
            'penduduk'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePendudukRequest $request, Penduduk $penduduk)
    {

        $validated = $request->validated();

        if ($request->file('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            Storage::disk('public')->delete($penduduk->foto_ktp);
        } else {
            $validated['foto_ktp'] = $penduduk->foto_ktp;
        }

        $penduduk->update($validated);

        return back()->with('success', 'Penduduk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return back()->with('success', 'Penduduk berhasil dihapus');
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $penduduk = $this->filter($request);

        if ($user->hasRole('rt')) {
            $penduduk
                ->whereHas('keluarga', function ($q) use ($user) {
                    $q->where('rt_id', $user->rt->id);
                });
            $fileName = 'Penduduk_RT_' . $user->rt->nomor;
        } else if ($user->hasRole('rw')) {
            $penduduk
                ->whereHas('keluarga.rt', function ($q) use ($user) {
                    $q->where('rw_id', $user->rt->rw->id);
                })
                ->when($request->has('rt'), function ($q) use ($request) {
                    $q->whereHas('keluarga.rt', function ($q) use ($request) {
                        $q->where('id', $request->get('rt'));
                    });
                });
            $fileName = $request->has('rt') ? 'Penduduk_RT_' . Rt::where('id', $request->get('rt'))->first()->nomor : 'Penduduk';
        } else {
            abort(403);
        }

        $penduduk = $penduduk->orderBy('keluarga_id', 'asc')->get();

        return Excel::download(new PendudukExport($penduduk), $fileName . '.' . strtolower($request->get('format')));
    }


    private function filter(Request $request)
    {
        $penduduk = Penduduk::with(['keluarga', 'agama', 'pekerjaan', 'pendidikan']);

        $penduduk->when($request->has('agama'), function ($q) use ($request) {
            return $q->whereHas('agama', function ($q) use ($request) {
                $q->where('id', $request->get('agama'));
            });
        });

        $penduduk->when($request->has('pekerjaan'), function ($q) use ($request) {
            return $q->whereHas('pekerjaan', function ($q) use ($request) {
                $q->where('id', $request->get('pekerjaan'));
            });
        });

        $penduduk->when($request->has('darah'), function ($q) use ($request) {
            return $q->whereHas('darah', function ($q) use ($request) {
                $q->where('id', $request->get('darah'));
            });
        });

        $penduduk->when($request->has('pendidikan'), function ($q) use ($request) {
            return $q->whereHas('pendidikan', function ($q) use ($request) {
                $q->where('id', $request->get('pendidikan'));
            });
        });

        $penduduk->when($request->has('status_perkawinan'), function ($q) use ($request) {
            return $q->whereHas('statusPerkawinan', function ($q) use ($request) {
                $q->where('id', $request->get('status_perkawinan'));
            });
        });

        $penduduk->when($request->has('status_hubungan_dalam_keluarga'), function ($q) use ($request) {
            return $q->whereHas('statusHubunganDalamKeluarga', function ($q) use ($request) {
                $q->where('id', $request->get('status_hubungan_dalam_keluarga'));
            });
        });

        $penduduk->when($request->has('jenis_kelamin'), function ($q) use ($request) {
            return $q->where('jenis_kelamin', $request->get('jenis_kelamin'));
        });

        $penduduk->when($request->has('age_min') && $request->has('age_max'), function ($q) use ($request) {
            $age_min = $request->get('age_min') ?? null;
            $age_max = $request->get('age_max') ?? null;
            if ($age_min && $age_max && $age_min <= $age_max) {
                $age_min = Carbon::now()->subYears($age_min)->format('Y-m-d');
                $age_max = Carbon::now()->subYears($age_max)->format('Y-m-d');
                return $q->whereBetween('tanggal_lahir', [$age_max, $age_min]);
            }
        });

        return $penduduk;
    }
}
