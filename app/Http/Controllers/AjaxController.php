<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Darah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AjaxController extends Controller
{

    public function __construct(Request $request)
    {
        abort_unless($request->ajax(), 404);
    }

    public function graphics(Request $request)
    {
        $data = [];
        $user = auth()->user() ?: abort(403);

        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $perkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $hubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');
        $penduduk =  Penduduk::query();

        if ($user->hasRole(['admin', 'rw'])) {
            $penduduk->whereHas('keluarga.rt', function ($q) use ($user) {
                $q->where('rw_id', $user->rt->rw_id);
            })->when($request->has('rt'), function ($q) {
                return $q->whereHas('keluarga.rt', function ($q) {
                    $q->where('id', request()->get('rt'));
                });
            });
        } else if ($user->hasRole('rt')) {
            $penduduk->whereHas('keluarga.rt', function ($q) use ($user) {
                $q->where('id', $user->rt_id);
            });
        } else {
            abort(403);
        }

        $penduduk = $penduduk->get();

        $data['totalPenduduk'] = $penduduk->count();

        foreach ($agama as $id  => $nama) {
            $data['agama'][] = [
                'name' => $nama,
                'y' => $penduduk->where('agama_id', $id)->count()
            ];
        }

        foreach ($darah as $id => $nama) {
            $data['darah'][] = [
                'name' => $nama,
                'y' => $penduduk->where('darah_id', $id)->count()
            ];
        }

        foreach ($pendidikan as $id => $nama) {
            $data['pendidikan'][] = [
                'name' => $nama,
                'y' => $penduduk->where('pendidikan_id', $id)->count()
            ];
        }

        foreach ($pekerjaan as $id => $nama) {
            $data['pekerjaan'][] = [
                'name' => $nama,
                'y' => $penduduk->where('pekerjaan_id', $id)->count()
            ];
        }

        foreach ($perkawinan as $id => $nama) {
            $data['perkawinan'][] = [
                'name' => $nama,
                'y' => $penduduk->where('status_perkawinan_id', $id)->count()
            ];
        }

        foreach ($hubunganDalamKeluarga as $id => $nama) {
            $data['hubunganDalamKeluarga'][] = [
                'name' => $nama,
                'y' => $penduduk->where('status_hubungan_dalam_keluarga_id', $id)->count()
            ];
        }

        foreach (['l' => 'Laki - Laki', 'p' => 'Perempuan'] as $key => $value) {
            $data['jenisKelamin'][] = [
                'name' => $value,
                'y' => $penduduk->where('jenis_kelamin', $key)->count()
            ];
        }

        foreach (['1' => 'Warga Negara Indonesia', '2' => 'Warga Negara Asing', '3' => 'Dua Kewarganegaraan'] as $key => $value) {
            $data['kewarganegaraan'][] = [
                'name' => $value,
                'y' => $penduduk->where('kewarganegaraan', $key)->count()
            ];
        }

        $pendudukLakiLaki = $penduduk->where('jenis_kelamin', 'l');
        $pendudukPerempuan = $penduduk->where('jenis_kelamin', 'p');

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

        $data['usia'] = [
            'kategori' => $kategori,
            'laki' => [$laki0, $laki1, $laki2, $laki3, $laki4],
            'perempuan' => [$perempuan0, $perempuan1, $perempuan2, $perempuan3, $perempuan4],
        ];

        return response()->json($data);
    }
}
