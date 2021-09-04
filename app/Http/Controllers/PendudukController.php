<?php

namespace App\Http\Controllers;

use App\Exports\PendudukExport;
use App\Http\Requests\Penduduk\StorePendudukRequest;
use App\Http\Requests\Penduduk\UpdatePendudukRequest;
use App\Imports\PendudukImport;
use App\Models\Agama;
use App\Models\Darah;
use App\Models\Keluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\Rt;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Reader;

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

    public function import(Request $request)
    {
        $request->validate([
            'file_penduduk' => ['file', 'mimes:xlsx,csv,xls', 'required', 'max:5000']
        ]);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet  = $reader->load($request->file('file_penduduk'));
        $penduduk = $spreadsheet->getSheet(0)->toArray();
        $headings = array_shift($penduduk);
        array_walk($penduduk, function (&$row) use ($headings) {
            $row = array_combine($headings, $row);
            $penduduk[] = $row;
        });

        $penduduk = collect($penduduk);

        $penduduk = $penduduk->map(function ($item) {
            $rt = Rt::where('nomor', 'like', "%{$item['no_rt']}%")->first();
            $golongan_darah = Darah::where('nama', 'like', "%{$item['golongan_darah']}%")->first();
            $agama = Agama::where('nama', 'like', "%{$item['agama']}%")->first();
            $pekerjaan = Pekerjaan::where('nama', 'like', "%{$item['pekerjaan']}%")->first();
            $pendidikan = Pendidikan::where('nama', 'like', "%{$item['pendidikan']}%")->first();
            $statusPerkawinan = StatusPerkawinan::where('nama', 'like', "%{$item['status_perkawinan']}%")->first();
            $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::where('nama', 'like', "%{$item['status_hubungan_dalam_keluarga']}%")->first();

            $rt_id = $rt ? $rt->id : null;
            $golongan_darah_id = $golongan_darah ? $golongan_darah->id : null;
            $agama_id = $agama ? $agama->id : null;
            $pekerjaan_id = $pekerjaan ? $pekerjaan->id : null;
            $pendidikan_id = $pendidikan ? $pendidikan->id : null;
            $status_perkawinan_id = $statusPerkawinan ? $statusPerkawinan->id : null;
            $status_hubungan_dalam_keluarga_id = $statusHubunganDalamKeluarga ? $statusHubunganDalamKeluarga->id : null;

            return [
                'rt_id' => $rt_id,
                'nomor' => $item['no_kk'],
                'alamat' => $item['alamat'],
                'agama_id' => $agama_id,
                'darah_id' => $golongan_darah_id,
                'pekerjaan_id' => $pekerjaan_id,
                'status_perkawinan_id' => $status_perkawinan_id,
                'pendidikan_id' => $pendidikan_id,
                'status_hubungan_dalam_keluarga_id' => $status_hubungan_dalam_keluarga_id,
                'kewarganegaraan' => 1,
                'nik' => $item['nik'],
                'nama' =>  $item['nama'],
                'tempat_lahir' => $item['tempat_lahir'],
                'tanggal_lahir' => $item['tanggal_lahir'],
                'jenis_kelamin' => $item['jenis_kelamin'],
                'no_paspor' =>  $item['no_paspor'],
                'no_kitas_kitap' =>  $item['no_kitas_kitap'],
                'nama_ayah' =>  $item['nama_ayah'],
                'nama_ibu' =>  $item['nama_ibu'],
                'email' =>  $item['email'],
                'no_hp' =>  $item['no_hp'],
            ];
        });

        $user = auth()->user();

        if ($user->hasRole('rt')) {
            $penduduk = $penduduk->filter(function ($item)  use ($user) {
                return $item['rt_id'] === $user->rt->id;
            });
        }

        DB::beginTransaction();

        try {
            $penduduk->each(function ($item) {
                $keluarga = Keluarga::where('nomor', $item['nomor'])->first();
                if ($keluarga === null) {
                    $keluarga = Keluarga::create($item);
                }

                $item['keluarga_id'] = $keluarga->id;
                $penduduk = Penduduk::where('nik', $item['nik'])->first();

                if ($penduduk === null) {
                    Penduduk::create($item);
                }
            });
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return back()->with('success', 'Data penduduk berhasil disimpan ke database');
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
