<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RwSeeder::class,
            RtSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            AgamaSeeder::class,
            DarahSeeder::class,
            PendidikanSeeder::class,
            PekerjaanSeeder::class,
            StatusPerkawinanSeeder::class,
            StatusHubunganDalamKeluargaSeeder::class,
        ]);
    }
}
