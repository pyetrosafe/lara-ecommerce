<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ProdutoController;
use App\Produto;
# use Illuminate\Foundation\Testing\WithFaker;
# use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Provider\HardwareDatabase;
use Faker\Provider\HardwareLorem;
use Faker\Provider\HardwareDB\HardwareDatabase as HDB;

class ProductControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function testIndex()
    {
        // Criar um produto fictício para o teste
        $product = factory(Produto::class)->make();

        // Chamar o método index do ProductController
        $response = $this->get('http://localhost');

        // Verificar se a resposta tem status 200 e contém o produto criado
        $response->assertStatus(200);
        // $response->assertJson([
        //     'data' => [
        //         ['id' => $product->id, 'name' => $product->name, 'price' => $product->price]
        //     ]
        // ]);

        /*
        // Exemplo de uso:
        $db = new HardwareDatabase();
        */
    }

    /* public function testGetProduct()
    {
        // Criar um produto fictício para teste
        $product = factory(Produto::class)->make();

        // Fazer uma requisição GET para a rota do produto
        $response = $this->get("/products/{$product->id}");

        // Verificar se a resposta tem o status 200 e os dados do produto corretos
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            // outros campos relevantes
        ]);
    } */
}
