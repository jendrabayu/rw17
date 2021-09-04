<?php

namespace Database\Seeders;

use App\Models\Rt;
use Illuminate\Database\Seeder;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rt::create(['rw_id' => 1, 'nomor' => '001']);
        Rt::create(['rw_id' => 1, 'nomor' => '002']);
        Rt::create(['rw_id' => 1, 'nomor' => '003']);
        Rt::create(['rw_id' => 1, 'nomor' => '004']);
        Rt::create(['rw_id' => 1, 'nomor' => '005']);
        Rt::create(['rw_id' => 1, 'nomor' => '006']);
        Rt::create(['rw_id' => 1, 'nomor' => '007']);
        Rt::create(['rw_id' => 1, 'nomor' => '008']);
    }
}
