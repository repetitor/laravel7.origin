<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => 'tag ' . Str::random(2)
    ];
});
