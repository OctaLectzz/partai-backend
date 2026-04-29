<?php

namespace Database\Factories;

use App\Models\Massa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Massa>
 */
class MassaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('################'),
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['M', 'F']),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-17 years')->format('Y-m-d'),
            'phone_number' => fake()->numerify('08##########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->streetAddress(),
            'rt' => fake()->numerify('0##'),
            'rw' => fake()->numerify('0##'),
            'province_id' => fake()->numerify('##'),
            'regency_id' => fake()->numerify('####'),
            'district_id' => fake()->numerify('#######'),
            'village_id' => fake()->numerify('##########'),
            'postal_code' => fake()->numerify('#####'),
            'latitude' => fake()->latitude(-8.5, -6.0),
            'longitude' => fake()->longitude(106.0, 112.0),
            'profession' => fake()->jobTitle(),
            'photo' => null,
            'notes' => fake()->optional(0.3)->sentence(),
            'status' => fake()->randomElement(['active', 'active', 'active', 'active', 'inactive']),
        ];
    }

    /**
     * Indicate that the massa is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the massa is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
