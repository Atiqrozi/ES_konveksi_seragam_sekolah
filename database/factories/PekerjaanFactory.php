<?php

namespace Database\Factories;

use App\Models\Pekerjaan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PekerjaanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pekerjaan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        
        return [
            'nama_pekerjaan' => $faker->sentence(2),
            'harga_pekerjaan' => $faker->randomNumber(5),
            'deskripsi_pekerjaan' => $faker->optional()->paragraph(),
        ];
    }
}
