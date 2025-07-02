<?php

use Faker\Generator as Faker;

$factory->define(App\Produto::class, function (Faker $faker) {

    $hardwareDB = new \Faker\Provider\HardwareDB\HardwareDatabase();
    return [
        'id' => $faker->randomNumber(2),
        'nome' => $hardwareDB->randomProdutoNome(),
        'descricao' => $faker->realText(100, 3),
        'cod_barras' => $faker->ean13(),
        'valor' => $faker->randomFloat(2, 50, 10000),
        'ativo' => $faker->boolean(),
        'imagem' => $faker->imageUrl(640, 480, 'business', true, 'Produto'),
        'quantidade' => $faker->numberBetween(0, 999999)
    ];
});
