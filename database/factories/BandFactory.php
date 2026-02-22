<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Band>
 */
class BandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Dummy-Band^^',
            'name_kana' => 'ダミーバンド',
            'genre' => $this->faker->randomElement(['Rock', 'Punk', 'Jazz', 'Pop']),
            'area' => $this->faker->city(),
            'youtube_urls' => ['khE2qYFHAk8', 'Mfy1HCD2sTk'], // 適当なID
            'image_path' => null,
            ];
    }
}
