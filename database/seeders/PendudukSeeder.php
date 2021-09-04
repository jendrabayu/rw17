<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\PendudukDomisili;
use App\Models\PendudukMeninggal;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Keluarga::factory()->count(50)->create();
        Penduduk::factory()->count(150)->create();
        PendudukDomisili::factory()->count(50)->create();
        PendudukMeninggal::factory()->count(25)->create();
    }
}
