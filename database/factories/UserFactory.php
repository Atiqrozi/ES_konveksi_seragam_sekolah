<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            'nama' => $faker->name(),
            'email' => $faker->unique->email(),
            'alamat' => $faker->address(),
            'no_telepon' => $faker->phoneNumber(),
            'password' => \Hash::make('password'),
            'jenis_kelamin' => \Arr::random(['Laki-Laki', 'Perempuan']),
            'tanggal_lahir' => $faker->date(),
        ];
    }
}
