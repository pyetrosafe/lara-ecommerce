<?php

use Faker\Generator as Faker;

$factory->define(App\PedidoStatus::class, function (Faker $faker) {
    return [
        'descricao' => $faker->word,
    ];
});
