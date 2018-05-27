<?php

use App\Event;
use App\NinjaProfile;
use Faker\Generator as Faker;

$factory->define(App\EventRegistration::class, function (Faker $faker) {
    return [
        'event_id' => Event::all()->random(),
        'user_id' => NinjaProfile::all()->random()->user->id,
        'parent_will_pick_up' => $faker->boolean(),
        'check_in_token' => $faker->password(30),
    ];
});
