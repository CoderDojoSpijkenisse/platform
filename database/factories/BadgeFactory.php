<?php

use Faker\Generator as Faker;

$factory->define(App\Badge::class, function (Faker $faker) {
    $type = $faker->randomElement([
        'Scratch',
        'php',
        'python',
        'Java',
        'AppInventor',
        'Arduino',
        'MicroBit'
    ]);

    $allLevels = [
        1 => 'Beginner',
        2 => 'Intermediate',
        3 => 'Expert',
        4 => 'Mentor',
    ];
    $level = $faker->randomKey($allLevels);

    return [
        'name' => vsprintf('%s %s', [$type, $allLevels[$level]]),
        'type' => $type,
        'level' => $level,
        'description' => $faker->words(5, true),
        'image_url' => $faker->imageUrl(30, 30),
    ];
});
