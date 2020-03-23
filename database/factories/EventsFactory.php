<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Events;
use Faker\Generator as Faker;

$factory->define(Events::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'date' => $faker->dateTime,
        'thumbnail' => $faker->url,
        'seats' => $faker->randomDigit,
        'postal_code' => '5673RE',
        'hnum' => '12A',
        'notification' => $faker->boolean
    ];
});