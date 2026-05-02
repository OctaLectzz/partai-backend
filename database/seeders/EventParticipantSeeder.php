<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Massa;
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
            $participantCount = rand(5, 100);

            $massas = Massa::inRandomOrder()->take($participantCount)->get();

            if ($massas->count() < $participantCount) {
                $additionalMassas = Massa::factory()->count($participantCount - $massas->count())->create();
                $massas = $massas->concat($additionalMassas);
            }

            foreach ($massas as $massa) {
                // Ensure it does not exceed the target participants
                if ($event->target_participants && $event->participants()->count() >= $event->target_participants) {
                    break;
                }

                // Ensure the massa is not already registered for this event
                if ($event->participants()->where('massa_id', $massa->id)->exists()) {
                    continue;
                }

                $status = $faker->randomElement(['registered', 'attended']);

                EventParticipant::create([
                    'event_id' => $event->id,
                    'massa_id' => $massa->id,
                    'message' => $faker->boolean(70) ? $faker->sentence() : null,
                    'status' => $status,
                    'attended_at' => $status === 'attended' ? clone $faker->dateTimeBetween($event->start_date, $event->end_date) : null,
                ]);
            }
        }
    }
}
