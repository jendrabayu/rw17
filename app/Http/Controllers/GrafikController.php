<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Darah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\Rt;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GrafikController extends Controller
{
    public function index()
    {
    }

    public function show(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole('rt')) {
            $totalPenduduk = Penduduk::whereHas('keluarga', function ($q) use ($user) {
                $q->where('rt_id', $user->rt->id);
            })->count();
        } elseif ($user->hasRole('rw')) {
            $totalPenduduk = Penduduk::when($request->has('rt'), function ($q) use ($user, $request) {
                return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                    $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                });
            })->count();
        } else {
            abort(403);
        }

        return response()->json([
            'totalPenduduk' => $totalPenduduk,
            'agama' => $this->grafikAgama($user, $request),
            'darah' => $this->grafikGolDarah($user, $request),
            'pekerjaan' => $this->grafikPekerjaan($user, $request),
            'perkawinan' => $this->grafikPerkawinan($user, $request),
            'hubunganDalamKeluarga' => $this->grafikHubunganDalamKeluarga($user, $request),
            'pendidikan' => $this->grafikPendidikan($user, $request),
            'usia' => $this->grafikUsia($user, $request),
            'jenisKelamin' => $this->grafikJenisKelamin($user, $request)
        ]);
    }

    private function grafikAgama($user, $request)
    {
        $data = [];
        $agama = Agama::all();

        if ($user->hasRole('rt')) {
            foreach ($agama as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->whereAgamaId($item->id)->count()
                ];
            }
        }

        if ($user->hasRole('rw')) {
            foreach ($agama as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->whereAgamaId($item->id)->count()
                ];
            }
        }


        return $data;
    }

    private function grafikGolDarah($user, $request)
    {
        $data = [];
        $darah = Darah::all();

        if ($user->hasRole('rt')) {
            foreach ($darah as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->whereDarahId($item->id)->count()
                ];
            }
        }

        if ($user->hasRole('rw')) {
            foreach ($darah as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->whereDarahId($item->id)->count()
                ];
            }
        }

        return $data;
    }

    private function grafikPekerjaan($user, $request)
    {
        $data = [];
        $pekerjaan = Pekerjaan::all();

        if ($user->hasRole('rt')) {
            foreach ($pekerjaan as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->wherePekerjaanId($item->id)->count()
                ];
            }
        }

        if ($user->hasRole('rw')) {
            foreach ($pekerjaan as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->wherePekerjaanId($item->id)->count()
                ];
            }
        }

        return $data;
    }

    private function grafikPerkawinan($user, $request)
    {
        $data = [];
        $perkawinan = StatusPerkawinan::all();

        if ($user->hasRole('rt')) {
            foreach ($perkawinan as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->whereStatusPerkawinanId($item->id)->count()
                ];
            }
        }

        if ($user->hasRole('rw')) {
            foreach ($perkawinan as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->whereStatusPerkawinanId($item->id)->count()
                ];
            }
        }

        return $data;
    }

    private function grafikHubunganDalamKeluarga($user, $request)
    {
        $data = [];
        $hubunganDalamKeluarga = StatusHubunganDalamKeluarga::all();

        if ($user->hasRole('rt')) {
            foreach ($hubunganDalamKeluarga as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->whereStatusHubunganDalamKeluargaId($item->id)->count()
                ];
            }
        }

        if ($user->hasRole('rw')) {
            foreach ($hubunganDalamKeluarga as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->whereStatusHubunganDalamKeluargaId($item->id)->count()
                ];
            }
        }

        return $data;
    }

    private function grafikPendidikan($user, $request)
    {
        $data = [];
        $pendidikan = Pendidikan::all();

        if ($user->hasRole('rt')) {
            foreach ($pendidikan as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->wherePendidikanId($item->id)->count()
                ];
            }
        }

        if ($user->hasRole('rw')) {
            foreach ($pendidikan as $item) {
                $data[] = [
                    'name' => $item->nama,
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->wherePendidikanId($item->id)->count()
                ];
            }
        }

        return $data;
    }

    private function grafikJenisKelamin($user, $request)
    {

        if ($user->hasRole('rt')) {
            $data = [
                [
                    'name' => 'Laki-Laki',
                    'y' =>  Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->where('jenis_kelamin', 1)->count()
                ],
                [
                    'name' => 'Perempuan',
                    'y' => Penduduk::whereHas('keluarga', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt->id);
                    })->where('jenis_kelamin', 2)->count()
                ]
            ];
        }

        if ($user->hasRole('rw')) {
            $data = [
                [
                    'name' => 'Laki-Laki',
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->where('jenis_kelamin', 'l')->count()
                ],
                [
                    'name' => 'Perempuan',
                    'y' => Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                        $q->where('rw_id', $user->rt->rw->id);
                    })->when($request->has('rt'), function ($q) use ($user, $request) {
                        return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                            $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                        });
                    })->where('jenis_kelamin', 'p')->count()
                ]
            ];
        }

        return $data;
    }

    private function grafikUsia($user, $request)
    {

        if ($user->hasRole('rt')) {
            $pendudukLakiLaki = Penduduk::whereHas('keluarga', function ($q) use ($user) {
                $q->where('rt_id', $user->rt->id);
            })->where('jenis_kelamin', 'l')->get();

            $pendudukPerempuan =  Penduduk::whereHas('keluarga', function ($q) use ($user) {
                $q->where('rt_id', $user->rt->id);
            })->where('jenis_kelamin', 'p')->get();
        }

        if ($user->hasRole('rw')) {
            $pendudukLakiLaki =  Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                $q->where('rw_id', $user->rt->rw->id);
            })->when($request->has('rt'), function ($q) use ($user, $request) {
                return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                    $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                });
            })->where('jenis_kelamin', 1)->get();

            $pendudukPerempuan = Penduduk::whereHas('keluarga.rt', function ($q) use ($user) {
                $q->where('rw_id', $user->rt->rw->id);
            })->when($request->has('rt'), function ($q) use ($user, $request) {
                return $q->whereHas('keluarga.rt', function ($q) use ($user, $request) {
                    $q->where('id', $request->get('rt'))->where('rw_id', $user->rt->rw->id);
                });
            })->where('jenis_kelamin', 2)->get();
        }

        $kategori = ['0 - 4 tahun', '5 - 17 tahun', '18 - 30 tahun', '31 - 60 tahun', '60+ tahun'];
        $laki0 = 0;
        $laki1 = 0;
        $laki2 = 0;
        $laki3 = 0;
        $laki4 = 0;
        $perempuan0 = 0;
        $perempuan1 = 0;
        $perempuan2 = 0;
        $perempuan3 = 0;
        $perempuan4 = 0;


        foreach ($pendudukLakiLaki as $penduduk) {
            $laki = (int) Carbon::parse($penduduk->tanggal_lahir)->diff(Carbon::now())->format('%y');
            if ($laki >= 0 && $laki <= 4) {
                $laki0 += 1;
            } elseif ($laki >= 5 && $laki <= 17) {
                $laki1 += 1;
            } elseif ($laki >= 18 && $laki <= 30) {
                $laki2 += 1;
            } elseif ($laki >= 31 && $laki <= 60) {
                $laki3 += 1;
            } elseif ($laki > 60) {
                $laki4 += 1;
            }
        }

        foreach ($pendudukPerempuan as $penduduk) {
            $perempuan = (int) Carbon::parse($penduduk->tanggal_lahir)->diff(Carbon::now())->format('%y');
            if ($perempuan >= 0 && $perempuan <= 4) {
                $perempuan0 += 1;
            } elseif ($perempuan >= 5 && $perempuan <= 17) {
                $perempuan1 += 1;
            } elseif ($perempuan >= 18 && $perempuan <= 30) {
                $perempuan2 += 1;
            } elseif ($perempuan >= 31 && $perempuan <= 60) {
                $perempuan3 += 1;
            } elseif ($perempuan > 60) {
                $perempuan4 += 1;
            }
        }

        return [
            'kategori'          => $kategori,
            'laki'              => [$laki0, $laki1, $laki2, $laki3, $laki4],
            'perempuan'         => [$perempuan0, $perempuan1, $perempuan2, $perempuan3, $perempuan4],
        ];
    }
}
