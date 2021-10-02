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
            'rt_id' => 6,
            'name' => 'Super Admin',
            'username' => 'admin123',
            'email' => 'admin123@mail.com',
            'password' => '$2y$10$irUht.Uep9qbUYKtX961le.ZKfeXD5MTkFY5BwBpdEC4pZ03xFbCW' //123
        ])->assignRole('admin');
    }
}
