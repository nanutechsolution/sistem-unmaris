<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Misal kita buat 10 post dummy
        for ($i = 1; $i <= 10; $i++) {
            $title = $faker->sentence(6, true);
            DB::table('posts')->insert([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i, // pastikan slug unik
                'content' => $faker->paragraphs(5, true),
                'category_id' => $faker->numberBetween(1, 5), // sesuaikan kategori yang ada
                'user_id' => $faker->numberBetween(1, 1), // sesuaikan user yang ada
                'featured_image' => 'https://picsum.photos/800/400?random=' . $i,
                'status' => $faker->randomElement(['Published', 'Draft']),
                'published_at' => $faker->dateTimeBetween('-1 years', 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
