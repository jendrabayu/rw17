<?php

namespace App\Http\Controllers\Rt;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
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
    public function __invoke(Request $request)
    {
        $rt_id = auth()->user()->rt->id;

        return view('rt.dashboard', [
            'total_pengguna' => User::where('rt_id', $rt_id)->count(),
            'total_penduduk' => Penduduk::whereHas('keluarga', function ($q) use ($rt_id) {
                $q->where('rt_id', $rt_id);
            })->count(),
            'total_rumah' => Rumah::where('rt_id', $rt_id)->count(),
            'total_keluarga' => Keluarga::where('rt_id', $rt_id)->count()
        ]);
    }
}
