<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => 'post ' . Str::random(2),
        'user_id' => $faker->numberBetween(1, 5)
    ];
});
