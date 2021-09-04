<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'rt_id' => 1,
            'name' => 'rt1',
            'username' => 'rt1',
            'email' => 'rt1@mail.com',
            'password' => '$2y$10$irUht.Uep9qbUYKtX961le.ZKfeXD5MTkFY5BwBpdEC4pZ03xFbCW' //123
        ])->assignRole('rw');

        User::create([
            'rt_id' => 2,
            'name' => 'rt2',
            'username' => 'rt2',
            'email' => 'rt2@mail.com',
            'password' => '$2y$10$irUht.Uep9qbUYKtX961le.ZKfeXD5MTkFY5BwBpdEC4pZ03xFbCW' //123
        ])->assignRole('rt');
        
        User::create([
            'rt_id' => 3,
            'name' => 'rt3',
            'username' => 'rt3',
            'email' => 'rt3@mail.com',
            'password' => '$2y$10$irUht.Uep9qbUYKtX961le.ZKfeXD5MTkFY5BwBpdEC4pZ03xFbCW' //123
        ])->assignRole('rt');
    }
}
