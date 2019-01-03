<?php

use Faker\Generator as Faker;
use App\Models\DbBlog\Article;

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

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4, true),
        'author' => $faker->name,
        'summary' => $faker->paragraph,
        'content_md' => $faker->paragraphs(10, true),
        'content_html' => $faker->paragraphs(10, true),
        'tags' => '',
        'status' => $faker->randomElement([0,1]),
    ];
});
