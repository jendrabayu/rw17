<?php

namespace Database\Factories;

use App\Models\Keluarga;
use App\Models\Rt;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeluargaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Keluarga::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rt_id' => Rt::where('rw_id', 1)->inRandomOrder()->first()->id,
            'nomor' => $this->faker->numerify('3509############'),
            'alamat' => $this->faker->address()
        ];
    }
}
