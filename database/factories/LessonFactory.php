<?php

use Faker\Generator as Faker;

$factory->define(App\Lesson::class, function (Faker $faker) {
    $type = $faker->randomElement([
        'Scratch',
        'php',
        'python',
        'Java',
        'AppInventor',
        'Arduino',
        'MicroBit'
    ]);

    return [
        'title' => vsprintf('%s: %s', [$type, $faker->sentence]),
        'type' => $type,
        'points' => $faker->numberBetween(1, 10),
        'level' => $faker->numberBetween(1, 5),
        'prerequisites' => $faker->paragraph,
        'description' => $faker->paragraphs(2, true)
    ];
});
