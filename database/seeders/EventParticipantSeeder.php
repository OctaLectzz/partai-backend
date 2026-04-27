<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $events = Event::all();

        if ($events->isEmpty()) {
            return;
        }

        foreach ($events as $event) {
            // Limit the number of dummy participants per event randomly
            $participantCount = rand(5, 20);

            for ($i = 0; $i < $participantCount; $i++) {
                // Ensure it does not exceed the target participants
                if ($event->target_participants && $event->participants()->count() >= $event->target_participants) {
                    break;
                }

                EventParticipant::create([
                    'event_id' => $event->id,
                    'name' => $faker->name,
                    'nik' => $faker->numerify('################'), // 16 digit NIK
                    'email' => $faker->unique()->safeEmail,
                    'whatsapp_number' => $faker->phoneNumber,
                    // Dummy region ID (Province, Regency/City, District, Village)
                    'province_id' => '31', // Example code for DKI Jakarta
                    'regency_id' => '3171', // Example code for South Jakarta
                    'district_id' => '317101',
                    'village_id' => '3171011001',
                    'message' => $faker->boolean(70) ? $faker->sentence() : null, // 70% chance of leaving a message
                ]);
            }
        }
    }
}
