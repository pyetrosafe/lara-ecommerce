<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Admin::class, function (Faker $faker) {
    return [
        'id_usuario' => factory(User::class)->create()->id,
        'nome' => $faker->name,
    ];
});
