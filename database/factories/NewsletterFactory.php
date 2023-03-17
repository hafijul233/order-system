<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Newsletter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Newsletter>
 */
class NewsletterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'newsletterable_type' => fake()->randomElement([Customer::class, Company::class]),
            'newsletterable_id' => fake()->numberBetween(1, 15),
            'email' => fake()->unique()->safeEmail(),
            'attempted' => fake()->numberBetween(1, 100),
            'subscribed' => true
        ];
    }
}
