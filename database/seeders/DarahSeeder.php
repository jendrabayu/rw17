<?php

namespace Database\Seeders;

use App\Models\Darah;
use Illuminate\Database\Seeder;

class DarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Darah::create(['nama' => 'A']);
        Darah::create(['nama' => 'A+']);
        Darah::create(['nama' => 'A-']);
        Darah::create(['nama' => 'B']);
        Darah::create(['nama' => 'B+']);
        Darah::create(['nama' => 'B-']);
        Darah::create(['nama' => 'O']);
        Darah::create(['nama' => 'O+']);
        Darah::create(['nama' => 'O-']);
        Darah::create(['nama' => 'AB']);
        Darah::create(['nama' => 'AB+']);
        Darah::create(['nama' => 'AB-']);
    }
}
