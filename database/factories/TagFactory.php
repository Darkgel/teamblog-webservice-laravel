<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/2
 * Time: 20:30
 */

use Faker\Generator as Faker;
use App\Models\DbBlog\Tag;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
    ];
});
