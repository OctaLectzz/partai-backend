<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'nik' => fake()->numerify('################'),
            'kta_number' => fake()->numerify('NP-#########'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone_number' => fake()->phoneNumber(),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(['M', 'F']),
            'religion' => fake()->randomElement(['islam', 'christian', 'catholic', 'hindu', 'buddhist', 'confucian']),
            'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
            'education' => fake()->randomElement(['high_school', 'associate_degree', 'bachelors_degree', 'masters_degree', 'doctorate']),
            'profession' => fake()->jobTitle(),
            'address' => fake()->streetAddress(),
            'rt' => fake()->numerify('0##'),
            'rw' => fake()->numerify('0##'),
            'province_id' => fake()->numerify('##'),
            'regency_id' => fake()->numerify('##.##'),
            'district_id' => fake()->numerify('##.##.##'),
            'village_id' => fake()->numerify('##.##.##.####'),
            'postal_code' => fake()->numerify('#####'),
            'role' => fake()->randomElement(['admin', 'board_member', 'member', 'sympathizer']),
            'type' => fake()->randomElement(['admin', 'user']),
            'status' => fake()->boolean(90), // 90% chance of being active
            'remember_token' => Str::random(10),
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
