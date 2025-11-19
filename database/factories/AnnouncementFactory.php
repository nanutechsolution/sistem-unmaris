<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        $title = $this->faker->sentence(6);

        return [
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . uniqid(),
            'body'         => $this->faker->paragraph(10),
            'unit'         => $this->faker->randomElement(['Rektorat', 'BAAK', 'LP3M', 'Prodi Teologi', 'Prodi Kebidanan']),
            'category_id'  => null,
            'status'       => 'Published',
            'published_at' => now()->subDays(rand(1, 30)),
            'expired_at'   => now()->addDays(rand(3, 14)),
            'created_by'   => User::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
