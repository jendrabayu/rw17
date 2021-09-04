<?php

namespace Database\Factories;

use App\Models\Agama;
use App\Models\Darah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PendudukDomisili;
use App\Models\Rt;
use App\Models\StatusPerkawinan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendudukDomisiliFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PendudukDomisili::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jenis_kelamin = $this->faker->randomElement(['l', 'p']);

        return [
            'rt_id' => Rt::inRandomOrder()->first()->id,
            'agama_id' => Agama::inRandomOrder()->first()->id,
            'darah_id' => Darah::inRandomOrder()->first()->id,
            'pekerjaan_id' => Pekerjaan::inRandomOrder()->first()->id,
            'status_perkawinan_id' => StatusPerkawinan::inRandomOrder()->first()->id,
            'pendidikan_id' => Pendidikan::inRandomOrder()->first()->id,
            'kewarganegaraan' => 1,
            'nik' => $this->faker->numerify('3509############'),
            'nama' => $this->faker->name($jenis_kelamin === 'l' ? 'male' : 'female'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d'),
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' =>  $this->faker->address(),
            'alamat_asal' =>  $this->faker->address(),
            'foto_ktp' => null,
            'no_hp' => $this->faker->numerify('+62###########'),
            'email' => $this->faker->freeEmail(),
        ];
    }
}
