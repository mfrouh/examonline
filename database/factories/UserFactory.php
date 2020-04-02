<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\exam;
use App\group;
use App\question;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('12345678'), // password
        'remember_token' => Str::random(10),
        'role'=>$faker->randomElement(['student','teacher']),
    ];
});
$factory->define(group::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id'=>User::all()->random()->id,
    ];
});
$factory->define(exam::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'group_id'=>group::all()->random()->id,
        'start' => now(),
        'end'=>now()->addDays(3),
        'time'=>rand(1,60),
        'gradepass'=>rand(1,100),
        'take'=>rand(1,5),
        'calculate'=>$faker->randomElement(['average','best']),
    ];
});
$factory->define(question::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence(),
        'exam_id'=>exam::all()->random()->id,
        'type'=>$faker->randomElement(['choiceone','trueorfalse','complete','multiplechoice']),
        'option1'=>$faker->name,
        'option2'=>$faker->name,
        'option3'=>$faker->name,
        'option4'=>$faker->name,
        'correctanswer'=>json_encode(["option1"]),
        'mark'=>rand(1,4),
    ];
});

