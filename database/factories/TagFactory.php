<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tag = [
            'name' => fake()->word(),
            'type' => 'Product',
        ];
        $tag['slug'] = Str::slug($tag['name']);

        return $tag;
    }
}
