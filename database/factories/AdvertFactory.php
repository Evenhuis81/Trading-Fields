<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pp4;
use App\Advert;
use Faker\Generator as Faker;

$factory->define(Advert::class, function (Faker $faker) {
    $count = Pp4::count();
    $zipcode = Pp4::where('id', rand(1, $count))->value('postcode');
    $letter1 = chr(rand(65,90));
    $letter2 = chr(rand(65,90));
    return [
        'title' => ucfirst($faker->word()).' '.ucfirst($faker->word()),
        'description' => $faker->realText(150),
        'condition_id' => rand(0, 1) ? null : rand(1, 3),
        'price' => rand(0, 500),
        'delivery_id' => rand(1, 3),
        'name' => rand(0, 1) ? "Adman" : "Adman2",
        'phonenr' => rand(0, 1) ? null : '06'.rand(00000000, 99999999),
        'zipcode' => $zipcode.$letter1.$letter2,
        'startbid' => rand(0, 1) ? null : rand(0, 200),
        'owner_id' => rand(2, 3),
    ];
});
