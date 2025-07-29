<?php

use Faker\Generator as Faker;

$factory->define(App\Produto::class, function (Faker $faker) {
    return [
        'nome' => mb_ucfirst($faker->word),
        'descricao' => $faker->sentence,
        'cod_barras' => $faker->ean13, // Add cod_barras
        'valor' => $faker->randomFloat(2, 10, 1000),
        'ativo' => $faker->boolean,
        'imagem' => $faker->imageUrl(), // Add imagem
        'quantidade' => $faker->numberBetween(0, 100), // Add quantidade
    ];
});
