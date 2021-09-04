<?php

namespace Database\Seeders;

use App\Models\Rw;
use Illuminate\Database\Seeder;

class RwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rw::create(['nomor' => '017']);
    }
}
