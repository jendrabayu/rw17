<?php

namespace Database\Factories;

use App\Models\Agama;
use App\Models\Darah;
use App\Models\Keluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendudukFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Penduduk::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jenis_kelamin = $this->faker->randomElement(['l', 'p']);

        return [
            'keluarga_id' => Keluarga::withCount('penduduk')->having('penduduk_count', '<', 7)->inRandomOrder()->first()->id,
            'agama_id' => Agama::inRandomOrder()->first()->id,
            'darah_id' => Darah::inRandomOrder()->first()->id,
            'pekerjaan_id' => Pekerjaan::inRandomOrder()->first()->id,
            'status_perkawinan_id' => StatusPerkawinan::inRandomOrder()->first()->id,
            'pendidikan_id' => Pendidikan::inRandomOrder()->first()->id,
            'status_hubungan_dalam_keluarga_id' => StatusHubunganDalamKeluarga::inRandomOrder()->first()->id,
            'kewarganegaraan' => 1,
            'nik' => $this->faker->numerify('3509############'),
            'nama' => $this->faker->name($jenis_kelamin === 'l' ? 'male' : 'female'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d'),
            'jenis_kelamin' => $jenis_kelamin,
            'no_paspor' =>  $this->faker->numerify('#######'),
            'no_kitas_kitap' => $this->faker->numerify('###########'),
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'no_hp' => $this->faker->numerify('+62###########'),
            'email' => $this->faker->freeEmail()
        ];
    }
}
