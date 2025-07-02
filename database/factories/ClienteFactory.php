<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Cliente::class, function (Faker $faker) {
    return [
        'id_usuario' => factory(User::class)->create()->id,
        'nome' => $faker->name,
        'cpf' => $faker->numerify('###########'), // 11 digits for CPF
        'telefone' => $faker->numerify('###########'), // 11 digits for phone
        'cep' => $faker->postcode, // Add cep
        'endereco' => $faker->address,
        'numero' => $faker->buildingNumber,
        'cidade' => $faker->city, // Add cidade
    ];
});
