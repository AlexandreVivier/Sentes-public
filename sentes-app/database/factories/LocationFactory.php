<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $locations = [
            'Phare de la lune',
            'Fort de Cognelot',
            'Ar-Pont',
            'Chevalerie de Sacé',
            'Mines du roi nain',
            'Sanatorium d\'Aincourt',
            'Archéosite de Caraman',
            'Ville des nains',
            'Ville des elfes',
            'Epitech',
        ];

        return [
            'title' => $this->faker->unique()->randomElement($locations),
            'number' => $this->faker->numberBetween(1, 100),
            'street' => $this->faker->streetName(),
            'city_name' => $this->faker->city(),
            'zip_code' => $this->faker->numerify('#####'),
        ];
    }
}
