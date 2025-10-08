<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produk::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        
        return [
            'nama_produk' => $faker->sentence(1),
            'stok_produk' => 0,
            'harga_produk_1' => $faker->randomNumber(5),
            'harga_produk_2' => $faker->randomNumber(5),
            'harga_produk_3' => $faker->randomNumber(5),
            'harga_produk_4' => $faker->randomNumber(5),
            'deskripsi_produk' => $faker->optional()->paragraph(),
        ];
    }
}
