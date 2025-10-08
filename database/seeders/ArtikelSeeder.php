<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ArtikelSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $startDate = Carbon::now()->subDays(19); // 20 days ago from today
        
        // Ambil user yang ada untuk dijadikan penulis
        $users = User::all();
        if ($users->isEmpty()) {
            return; // Skip jika tidak ada user
        }

        foreach (range(1, 20) as $index) {
            DB::table('artikels')->insert([
                'penulis' => $users->random()->id, // Gunakan user yang benar-benar ada
                'judul' => $faker->sentence,
                'konten' => $faker->paragraphs(3, true),
                'slug' => $faker->slug,
                'cover' => 'public/artikel_cover/a.png',
                'created_at' => $startDate->copy()->addDays($index),
                'updated_at' => $startDate->copy()->addDays($index),
            ]);
        }
    }
}
