<?php

use App\Event;
use App\EventRegistration;
use App\MentorProfile;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Event::class, 10)->states(['past'])->create()->each(function (Event $event) {
            $faker = Faker\Factory::create();

            factory(EventRegistration::class, $faker->numberBetween(0, $event->capacity))->create([
                'event_id' => $event->id,
                'checked_in_at' => $faker->dateTimeBetween($event->timeStart, $event->timeEnd),
                'checked_in_by' => MentorProfile::all()->random()->user->id,
            ])->each(function(EventRegistration $registration) use ($faker) {
                if ($faker->boolean(10)) {
                    $registration->update([
                        'checked_in_at' => null,
                        'checked_in_by' => null,
                    ]);
                }
            });
        });
        factory(Event::class, 20)->states(['future'])->create()->each(function (Event $event) {
            $faker = Faker\Factory::create();

            factory(EventRegistration::class, $faker->numberBetween(0, $event->capacity))->create([
                'event_id' => $event->id,
            ]);
        });;
    }
}
