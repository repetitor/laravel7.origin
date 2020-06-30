<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Description;
use Faker\Generator as Faker;

$factory->define(Description::class, function (Faker $faker) {
    return [
        'name' => 'description ' . Str::random(2),
        'descriptionable_id' => rand(1, 5),
        'descriptionable_type' => ['App\User', 'App\models\Post'][rand(0, 1)],
    ];
});
