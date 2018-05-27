<?php

use App\MentorProfile;
use App\NinjaProfile;
use App\ParentProfile;
use App\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('nl_NL');

        $this->generateMentorProfiles(10, $faker);
        $this->generateNinjaProfiles(50, $faker);
        $this->generateParentProfiles(40, $faker);

        factory(User::class, 1)->create([
            'email' => 'mentor@cdsp.test',
        ])->each(function (User $user) use ($faker) {
            $mentorProfile = new MentorProfile([
                'user_id' => $user->id,
                'phone' => $faker->phoneNumber,
            ]);
            $mentorProfile->save();
        });

        factory(User::class, 1)->create([
            'email' => 'ninja-young@cdsp.test',
        ])->each(function (User $user) use ($faker) {
            $ninjaProfile = new NinjaProfile([
                'user_id' => $user->id,
                'date_of_birth' => $faker->dateTimeBetween(Carbon::now()->subYear(10), Carbon::now()->subYear(7)),
                'year_of_school' => $faker->numberBetween(4, 6),
            ]);
            $ninjaProfile->save();

            factory(User::class, 1)->create([
                'email' => 'parent-young@cdsp.test',
            ])->each(function (User $user) use ($faker) {
                $parentProfile = new ParentProfile([
                    'user_id' => $user->id,
                    'phone' => $faker->phoneNumber,
                    'will_pickup_children' => true,
                ]);
                $parentProfile->save();
            });

            $parent = User::where('email', 'parent-young@cdsp.test')->first()->parentProfile;
            $ninja = User::where('email', 'ninja-young@cdsp.test')->first()->ninjaProfile;
            $parent->children()->attach([$ninja->id]);
        });

        factory(User::class, 1)->create([
            'email' => 'ninja-old@cdsp.test',
        ])->each(function (User $user) use ($faker) {
            $ninjaProfile = new NinjaProfile([
                'user_id' => $user->id,
                'date_of_birth' => $faker->dateTimeBetween(Carbon::now()->subYear(17), Carbon::now()->subYear(12)),
                'year_of_school' => 3,
            ]);
            $ninjaProfile->save();
        });
    }

    /**
     * Generate user accounts for ninjas.
     *
     * @param int $amount Amount of profiles to generate
     * @param Generator $faker Faker for fake data generation
     */
    private function generateNinjaProfiles(int $amount, Generator $faker)
    {
        factory(User::class, $amount)->create()->each(function (User $user) use ($faker) {
            $ninjaProfile = new NinjaProfile([
                'user_id' => $user->id,
                'date_of_birth' => $faker->dateTimeBetween(Carbon::now()->subYear(17), Carbon::now()->subYear(7)),
                'year_of_school' => $faker->numberBetween(1, 8),
            ]);
            $ninjaProfile->save();
        });
    }

    /**
     * Generate user accounts for mentors.
     *
     * @param int $amount Amount of profiles to generate
     * @param Generator $faker Faker for fake data generation
     */
    private function generateMentorProfiles(int $amount, Generator $faker)
    {
        factory(User::class, $amount)->create()->each(function (User $user) use ($faker) {
            $mentorProfile = new MentorProfile([
                'user_id' => $user->id,
                'phone' => $faker->phoneNumber,
            ]);
            $mentorProfile->save();
        });
    }

    /**
     * Generate user accounts for parents.
     *
     * @param int $amount Amount of profiles to generate
     * @param Generator $faker Faker for fake data generation
     */
    private function generateParentProfiles(int $amount, Generator $faker)
    {
        $allNinjaProfiles = NinjaProfile::all();

        factory(User::class, $amount)->create()->each(function (User $user) use ($faker, $allNinjaProfiles) {
            $parentProfile = new ParentProfile([
                'user_id' => $user->id,
                'phone' => $faker->phoneNumber,
                'will_pickup_children' => $faker->boolean,
            ]);
            $parentProfile->save();

            $amountOfChildren = $faker->numberBetween(0, 2);
            $childrenToAssignToParent = [];

            for (; $amountOfChildren > 0; $amountOfChildren--) {
                if ($allNinjaProfiles->isNotEmpty()) {
                    $childrenToAssignToParent[$allNinjaProfiles->pop()->id] = [
                         'relation' => $faker->randomElement(['mother', 'father', null])
                    ];
                }
            }

            $parentProfile->children()->attach($childrenToAssignToParent);
        });
    }
}
