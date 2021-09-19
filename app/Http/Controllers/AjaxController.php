<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Rt;
use App\Models\Rumah;

class AjaxController extends Controller
{
    public function getKeluarga($rt_id)
    {
        $rt = Rt::findOrFail($rt_id);
        $keluarga = $rt->keluarga()->doesntHave('rumah')->get()->map(function ($keluarga) {
            return [
                'id' => $keluarga->id,
                'nomor' => $keluarga->nomor
            ];
        });

        return response()->json($keluarga);
    }

    public function getPenduduk($rt_id)
    {
        $rt = Rt::findOrFail($rt_id);
        $penduduk = Penduduk::query()->whereHas('keluarga', function ($q) use ($rt) {
            return $q->where('rt_id', $rt->id);
        });

        $penduduk = $penduduk->orderBy('keluarga_id')->get();
        $penduduk = $penduduk->map(function ($penduduk) {
            return [
                'id' => $penduduk->id,
                'nama' => $penduduk->nama,
                'nik' => $penduduk->nik,
            ];
        });

        return response()->json($penduduk);
    }
}
