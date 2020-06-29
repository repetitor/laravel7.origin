<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name' => 'comment ' . Str::random(2),
        'post_id' => $faker->numberBetween(1, 5)
    ];
});
