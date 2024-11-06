<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => fake()->isbn13(),
            'title' => fake()->sentence(),
            'description' => fake()->text(100),
            'publisher' => fake()->company(),
            'release_date' => fake()->date('Y-m-d'),
            'pages' => fake()->numberBetween(50,1000),
            'language' => fake()->languageCode(),
            'volumen' => fake()->numberBetween(1,10),
            'image' => null,
        ];
    }
}
