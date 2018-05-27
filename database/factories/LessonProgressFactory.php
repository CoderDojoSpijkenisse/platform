<?php

use App\Lesson;
use App\MentorProfile;
use App\NinjaProfile;
use Faker\Generator as Faker;

$factory->define(App\LessonProgress::class, function (Faker $faker) {
    $signedOff = $faker->boolean(20);

    return [
        'ninja_profile_id' => NinjaProfile::all()->random()->id,
        'lesson_id' => Lesson::all()->random()->id,
        'feedback' => $faker->numberBetween(0, 3),
        'signed_off_by' => $signedOff ? MentorProfile::all()->random()->user->id : null,
        'signed_off_at' => $signedOff ? $faker->dateTime : null,
        'notes' => $faker->boolean(10) ? $faker->paragraph : null,
        'public' => $faker->boolean(5),
    ];
});
