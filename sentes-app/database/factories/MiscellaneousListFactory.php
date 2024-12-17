<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\miscellaneousList>
 */
class MiscellaneousListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'author_id' => \App\Models\User::factory(),
            'miscellaneous_category_id' => \App\Models\MiscellaneousCategory::factory(),
            'description' => $this->faker->text,
        ];
    }
}
