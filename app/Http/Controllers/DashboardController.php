<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\PendudukDomisili;
use App\Models\PendudukMeninggal;
use App\Models\Rumah;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $user = auth()->user();
        $userRt = $user->rt;

        if ($user->hasRole('rt')) {
            $data = [
                'total_pengguna' => User::where('rt_id', $userRt->id)->count(),
                'total_penduduk' => Penduduk::whereHas('keluarga', function ($q) use ($userRt) {
                    $q->where('rt_id', $userRt->id);
                })->count(),
                'total_rumah' => Rumah::where('rt_id', $userRt->id)->count(),
                'total_keluarga' => Keluarga::where('rt_id', $userRt->id)->count(),
                'total_penduduk_domisili' => PendudukDomisili::where('rt_id', $userRt->id)->count(),
                'total_penduduk_meninggal' => PendudukMeninggal::where('rt_id', $userRt->id)->count()
            ];
        }

        if ($user->hasRole(['rw', 'admin'])) {
            $data = [
                'total_pengguna' => User::count(),
                'total_penduduk' => Penduduk::count(),
                'total_penduduk_meninggal' => PendudukMeninggal::count(),
                'total_penduduk_domisili' => PendudukDomisili::count(),
                'total_rumah' => Rumah::count(),
                'total_keluarga' => Keluarga::count(),
                'rt' => $userRt->rw->rt->pluck('nomor', 'id')
            ];
        }

        return view('dashboard', $data);
    }
}
