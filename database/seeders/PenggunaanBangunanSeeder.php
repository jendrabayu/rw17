<?php

namespace Database\Seeders;

use App\Models\PenggunaanBangunan;
use Illuminate\Database\Seeder;

class PenggunaanBangunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PenggunaanBangunan::insert([
            ['nama' => 'Rumah Tinggal'],
            ['nama' => 'Rumah Kontrakan'],
            ['nama' => 'Kos-Kosan'],
            ['nama' => 'Kantor'],
            ['nama' => 'Toko/Apotek/Pasar/Ruko'],
            ['nama' => 'Rumah Sakit/Klinik'],
            ['nama' => 'Pabrik'],
            ['nama' => 'Olah Raga/Rekreasi'],
            ['nama' => 'Hotel/Restoran/Wisma;'],
            ['nama' => 'Bengkel/Gudang/Pertanian'],
            ['nama' => 'Gedung Pemerintah'],
            ['nama' => 'Bangunan Tidak Kena Pajak'],
            ['nama' => 'Bangunan Parkir'],
            ['nama' => 'Apartemen/Kondominium;'],
            ['nama' => 'Pompa Bensin (kanopi)'],
            ['nama' => 'Tangki Minyak'],
            ['nama' => 'Gedung Sekolah'],
            ['nama' => 'Lain-Lain'],
        ]);
    }
}
