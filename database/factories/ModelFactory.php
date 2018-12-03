<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\BackEnd\Capacity\Subject::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->numerify('SUB###'),
        'name' => $faker->word,
        'description' => $faker->text,
    ];
});

$factory->define(App\Models\BackEnd\Capacity\Location::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->numerify('LOC###'),
        'name' => $faker->word,
        'description' => $faker->text,
    ];
});

$factory->define(App\Models\BackEnd\Capacity\Room::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->numerify('ROO###'),
        'name' => $faker->word,
        'location_id' => factory(App\Models\BackEnd\Capacity\Location::class,1)->create()->id,
        'description' => $faker->text,
    ];
});

$factory->define(App\Models\BackEnd\Capacity\Course::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->numerify('COU###'),
        'name' => $faker->word,
        'description' => $faker->text,
    ];
});

$factory->define(App\Models\BackEnd\Capacity\Course::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->numerify('COU###'),
        'name' => $faker->word,
        'description' => $faker->text,
    ];
});
