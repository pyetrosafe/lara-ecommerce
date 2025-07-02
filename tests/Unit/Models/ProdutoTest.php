<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Produto;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_produto()
    {
        // Arrange: Create a produto instance using the factory
        $produto = factory(Produto::class)->create();

        // Assert: Check if the produto exists in the database
        $this->assertDatabaseHas('tbl_produto', [
            'id' => $produto->id,
            'nome' => $produto->nome,
        ]);
    }

    /**
     * @test
     */
    public function produto_attributes_are_set_correctly()
    {
        // Arrange: Create a produto with specific data
        $produto = factory(Produto::class)->create([
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto de teste.',
            'valor' => 99.99,
            'ativo' => true,
            'cod_barras' => '1234567890123',
            'imagem' => 'http://example.com/image.jpg',
            'quantidade' => 10,
        ]);

        // Act: Retrieve the produto from the database
        $foundProduto = Produto::find($produto->id);

        // Assert: Check if the attributes are correct
        $this->assertEquals('Produto Teste', $foundProduto->nome);
        $this->assertEquals('Descrição do produto de teste.', $foundProduto->descricao);
        $this->assertEquals(99.99, $foundProduto->valor);
        $this->assertTrue($foundProduto->ativo);
        $this->assertEquals('1234567890123', $foundProduto->cod_barras);
        $this->assertEquals('http://example.com/image.jpg', $foundProduto->imagem);
        $this->assertEquals(10, $foundProduto->quantidade);
    }

    /**
     * @test
     */
    public function it_belongs_to_many_pedidos()
    {
        // Arrange: Create a Produto and associated Pedidos through the pivot table
        $produto = factory(Produto::class)->create();
        $pedidos = factory(\App\Pedido::class, 2)->create();

        foreach ($pedidos as $pedido) {
            $produto->Pedido()->attach($pedido->id, [
                'valor' => rand(10, 100),
                'quantidade' => rand(1, 5),
            ]);
        }

        // Act: Retrieve the related Pedidos
        $foundPedidos = $produto->fresh()->Pedido;

        // Assert: Check if the relationship returns the correct number of Pedidos
        $this->assertCount(2, $foundPedidos);
        $this->assertInstanceOf('App\\Pedido', $foundPedidos->first());

        // Assert: Check if pivot data is accessible
        $this->assertNotNull($foundPedidos->first()->PedidoItem->valor);
        $this->assertNotNull($foundPedidos->first()->PedidoItem->quantidade);
    }
}
