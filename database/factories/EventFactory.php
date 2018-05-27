<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => vsprintf('Dojo #%s: %s', [$faker->numberBetween(1, 40), $faker->words(4, true)]),
        'capacity' => $faker->randomElement([15, 20, 25]),
        'address_street' => $faker->streetAddress,
        'address_postal_code' => $faker->postcode,
        'address_city' => $faker->city,
    ];
});

$factory->state(App\Event::class, 'future', function (Faker $faker) {
    $date = $faker->dateTimeBetween(Carbon::now()->toDateTimeString(), Carbon::now()->addYear()->toDateTimeString());
    $startTime = $date->setTime($faker->numberBetween(10, 13), $faker->randomElement([0, 15, 30, 45]), 0);
    $endTime = clone $date;
    $endTime->modify(vsprintf('+%s hours', [$faker->numberBetween(2, 5)]));

    return ['time_start' => $startTime, 'time_end' => $endTime];
});

$factory->state(App\Event::class, 'past', function (Faker $faker) {
    $date = $faker->dateTimeBetween(Carbon::now()->subYear()->toDateTimeString(), Carbon::now()->toDateTimeString());
    $startTime = $date->setTime($faker->numberBetween(10, 13), $faker->randomElement([0, 15, 30, 45]), 0);
    $endTime = clone $date;
    $endTime->modify(vsprintf('+%s hours', [$faker->numberBetween(2, 5)]));

    return ['time_start' => $startTime, 'time_end' => $endTime];
});