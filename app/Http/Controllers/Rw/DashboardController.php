<?php

namespace App\Http\Controllers\Rw;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\PendudukDomisili;
use App\Models\PendudukMeninggal;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Http\Request;

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
        return view('rw.dashboard', [
            'total_pengguna' => User::count(),
            'total_penduduk' => Penduduk::count(),
            'total_penduduk_meninggal' => PendudukMeninggal::count(),
            'total_penduduk_domisili' => PendudukDomisili::count(),
            'total_rumah' => Rumah::count(),
            'total_keluarga' => Keluarga::count(),
            'rt' => auth()->user()->rt->rw->rt->pluck('nomor', 'id')
        ]);
    }
}
