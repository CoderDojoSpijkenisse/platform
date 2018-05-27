<?php

use App\Lesson;
use App\LessonProgress;
use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Lesson::class, 30)->create()->each(function (Lesson $lesson) {
            factory(LessonProgress::class, mt_rand(0, 4))->create([
                'lesson_id' => $lesson->id,
            ]);
        });
    }
}
