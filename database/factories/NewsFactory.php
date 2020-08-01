<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use App\Category;
use App\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    $authorIDs = Author::all()->pluck('id')->toArray();
    $categoryIDs = Category::all()->pluck('id')->toArray();

    return [
        'name' => $faker->sentence,
        'author_id' => $authorIDs[array_rand($authorIDs)],
        'category_id' => $authorIDs[array_rand($categoryIDs)],
        'description' => $faker->text,
    ];
});
