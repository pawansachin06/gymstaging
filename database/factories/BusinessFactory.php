<?php

$factory->define(App\Models\Business::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
