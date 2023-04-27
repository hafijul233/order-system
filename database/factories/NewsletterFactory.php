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
        $profile['newsletterable_type'] = fake()->randomElement([Customer::class, Company::class]);
        $profile['newsletterable_id'] = ($profile['newsletterable_type'] == Customer::class)
            ? fake()->numberBetween(1, 50)
            : fake()->numberBetween(51, 100);

        $profile['email'] = fake()->unique()->safeEmail();
        $profile['attempted'] = fake()->numberBetween(1, 100);
        $profile['subscribed'] = fake()->randomElement([true, false]);

        return $profile;
    }
}
