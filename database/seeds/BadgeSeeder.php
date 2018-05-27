<?php

use App\Badge;
use App\MentorProfile;
use App\NinjaProfile;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Badge::class, 15)->create()->each(function (Badge $badge) {
            $ninjaIds = NinjaProfile::inRandomOrder()->limit(mt_rand(0, 5))->select('id')->pluck('id')->all();

            $badge->ninjas()->attach(array_map(function (int $ninjaId) {
                return [
                    'rewarded_by' => MentorProfile::inRandomOrder()->first()->user->id
                ];
            }, array_flip($ninjaIds)));
        });
    }
}
