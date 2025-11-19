<?php

namespace Database\Factories;

use App\Models\QualityAnnouncement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QualityAnnouncementFactory extends Factory
{
    /**
     * Nama model yang sesuai dengan factory ini.
     *
     * @var string
     */
    protected $model = QualityAnnouncement::class;

    /**
     * Definisikan status default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        $userId = User::inRandomOrder()->first()->id ?? 1;

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'content' => '<p>' . $this->faker->paragraphs(3, true) . '</p>',
            'published_at' => $this->faker->optional(0.9)->dateTimeBetween('-6 months', 'now'),
            'posted_by' => $userId,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
