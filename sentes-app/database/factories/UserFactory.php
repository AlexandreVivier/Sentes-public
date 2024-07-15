<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'login' => $this->faker->unique()->firstName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'accepted_terms' => true,
            'avatar_path' => 'images/static/blank-profile.png',
            'biography' => $this->faker->paragraph(),
            'pronouns' => $this->faker->randomElement(['il/lui', 'elle', 'iel/ael']),
            'diet_restrictions' => $this->faker->randomElement(['Végétarien', 'Végétalien', 'Sans gluten', 'Sans lactose', 'Halal', 'Casher', 'Autre']),
            'allergies' => $this->faker->randomElement(['Arachides', 'Fruits de mer', 'Lactose', 'Gluten', 'Noix', 'Soja', 'Autre']),
            'medical_conditions' => $this->faker->randomElement(['Diabète', 'Asthme', 'Épilepsie', 'Autre']),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone_number' => $this->faker->phoneNumber(),
            'red_flag_people' => $this->faker->name(),
            'first_aid_qualifications' => $this->faker->randomElement(['Aucune', 'PSC1', 'PSE1', 'PSE2', 'PSC1 et PSE1', 'PSC1 et PSE2', 'PSE1 et PSE2', 'PSC1, PSE1 et PSE2']),
            'phone_number' => $this->faker->phoneNumber(),
            'discord_username' => $this->faker->userName(),
            'facebook_username' => $this->faker->userName(),
            'trigger_warnings' => $this->faker->sentence(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
