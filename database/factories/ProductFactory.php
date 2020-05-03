<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(300),
        'price' => $faker->randomFloat(2,1,300),
        'unique_id' => uniqid(true),
        'stock' => $faker->randomNumber(2),
        'category_id' => rand(1,4),
        'user_id' => rand(1,2),
        'is_approved' => $faker->boolean(),
        'is_published' => $faker->boolean(),
    ];
});
