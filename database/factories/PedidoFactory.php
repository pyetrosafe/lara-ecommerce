<?php

use Faker\Generator as Faker;
use App\Cliente;
use App\PedidoStatus;

$factory->define(App\Pedido::class, function (Faker $faker) {
    return [
        'id_cliente' => factory(Cliente::class)->create()->id,
        'id_pedido_status' => factory(PedidoStatus::class)->create()->id,
        'numero' => $faker->unique()->randomNumber(8),
        'valor' => $faker->randomFloat(2, 10, 1000),
    ];
});
