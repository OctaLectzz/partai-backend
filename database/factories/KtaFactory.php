<?php

namespace Database\Factories;

use App\Models\Kta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kta>
 */
class KtaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'position' => $this->faker->jobTitle(),
            'address' => $this->faker->address(),
            'rt' => $this->faker->numerify('###'),
            'rw' => $this->faker->numerify('###'),
            'province_id' => '11', // Aceh as default for seeding
            'regency_id' => '1101',
            'district_id' => '1101010',
            'village_id' => '1101010001',
            'postal_code' => $this->faker->postcode(),
            'photo' => 'https://ui-avatars.com/api/?name='.urlencode($this->faker->name()).'&background=random',
            'created_at' => $createdAt = $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $createdAt,
        ];
    }
}
