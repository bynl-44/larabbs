<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();

    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'content' => $faker->sentence(),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
