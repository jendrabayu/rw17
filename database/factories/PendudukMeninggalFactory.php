<?php

namespace Database\Factories;

use App\Models\Penduduk;
use App\Models\PendudukMeninggal;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendudukMeninggalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PendudukMeninggal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $sebab_kematian = [
            'Sakit',
            'Kecelakaan',
            'Jatuh',
            'Tenggelam',
            'Dibunuh',
            'Keracuanan',
            'COVID-19',
            'Tergigit Ular'
        ];

        $tempat_pemakaman = [
            'TPU Karet Bivak',
            'TPU Petamburan',
            'TPU Kawi - Kawi',
            'TPU Karet Pasar Baru Barat',
            'TPU Semper',
            'TPU Jembatan Sampi',
            'TPU Bulak Turi',
            'TPU Malaka  IV  Rorotan',
            'TPU Malaka I Rorotan ',
            'TPU Plumpang',
            'TPU Kampung Mangga',
            'TPU Sungai Bambu',
            'TPU Tegal Kunir',
            'TPU Rorotan',
            'TPU Tegal Alur I',
            'TPU Tegal Alur II',
            'TPU Sukabumi Selatan',
            'TPU Joglo',
            'TPU Grogol Kemanggisan',
        ];

        $tempat = [
            'Rumah',
            'Rumah Sakit',
            'Jalan',
            'Laut',
            'Gunung',
            'Kendaraan'
        ];
        $pendudukMeninggal = Penduduk::inRandomOrder()->first();
        $penduduk = $pendudukMeninggal;
        $pendudukMeninggal->delete();

        return [
            'rt_id' => $penduduk->keluarga->rt->id,
            'agama_id' => $penduduk->agama_id,
            'darah_id' => $penduduk->darah_id,
            'pekerjaan_id' => $penduduk->pekerjaan_id,
            'status_perkawinan_id' => $penduduk->status_perkawinan_id,
            'pendidikan_id' => $penduduk->pendidikan_id,
            'kewarganegaraan' => 1,
            'nik' => $penduduk->nik,
            'nama' => $penduduk->nama,
            'tempat_lahir' => $penduduk->tempat_lahir,
            'tanggal_lahir' => $penduduk->tanggal_lahir,
            'jenis_kelamin' => $penduduk->jenis_kelamin,
            'nama_ayah' => $penduduk->nama_ayah,
            'nama_ibu' => $penduduk->nama_ibu,
            'foto_ktp' => $penduduk->foto_ktp,
            'alamat' => $penduduk->keluarga->alamat,
            'tanggal_kematian' => $this->faker->date('Y:m:d'),
            'jam_kematian' => $this->faker->date('H:i'),
            'tempat_kematian' => $this->faker->randomElement($tempat),
            'sebab_kematian' => $this->faker->randomElement($sebab_kematian),
            'tempat_pemakaman' => $this->faker->randomElement($tempat_pemakaman),
        ];
    }
}
