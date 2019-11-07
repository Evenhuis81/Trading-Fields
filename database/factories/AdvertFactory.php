<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Advert;
use Faker\Generator as Faker;

$factory->define(Advert::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->word()).' '.ucfirst($faker->word()),
        'description' => $faker->realText(150),
        'price' => rand(0,500),
        'category' => rand(1,5),
        'startbid' => rand(0,1) ? rand(0,200) : null,
        'owner_id' => rand(2,3),
    ];
});
