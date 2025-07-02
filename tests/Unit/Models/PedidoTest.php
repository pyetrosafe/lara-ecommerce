<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Pedido;
use App\Cliente;
use App\PedidoStatus;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_pedido()
    {
        // Arrange: Create a Pedido instance using the factory
        $pedido = factory(Pedido::class)->create();

        // Assert: Check if the Pedido exists in the database
        $this->assertDatabaseHas('tbl_pedido', [
            'id' => $pedido->id,
            'numero' => $pedido->numero,
        ]);
    }

    /**
     * @test
     */
    public function pedido_attributes_are_set_correctly()
    {
        // Arrange: Create a Cliente and PedidoStatus
        $cliente = factory(Cliente::class)->create();
        $pedidoStatus = factory(PedidoStatus::class)->create();

        // Arrange: Create a Pedido with specific data
        $pedido = factory(Pedido::class)->create([
            'id_cliente' => $cliente->id,
            'id_pedido_status' => $pedidoStatus->id,
            'numero' => 'PEDIDO123',
            'valor' => 150.75,
        ]);

        // Act: Retrieve the Pedido from the database
        $foundPedido = Pedido::find($pedido->id);

        // Assert: Check if the attributes are correct
        $this->assertEquals($cliente->id, $foundPedido->id_cliente);
        $this->assertEquals($pedidoStatus->id, $foundPedido->id_pedido_status);
        $this->assertEquals('PEDIDO123', $foundPedido->numero);
        $this->assertEquals(150.75, $foundPedido->valor);
    }

    /**
     * @test
     */
    public function it_belongs_to_many_produtos()
    {
        // Arrange: Create a Pedido and associated Produtos through the pivot table
        $pedido = factory(Pedido::class)->create();
        $produtos = factory(\App\Produto::class, 2)->create();

        foreach ($produtos as $produto) {
            $pedido->Produtos()->attach($produto->id, [
                'valor' => rand(10, 100),
                'quantidade' => rand(1, 5),
            ]);
        }

        // Act: Retrieve the related Produtos
        $foundProdutos = $pedido->fresh()->Produtos;

        // Assert: Check if the relationship returns the correct number of Produtos
        $this->assertCount(2, $foundProdutos);
        $this->assertInstanceOf('App\\Produto', $foundProdutos->first());

        // Assert: Check if pivot data is accessible
        $this->assertNotNull($foundProdutos->first()->PedidoItem->valor);
        $this->assertNotNull($foundProdutos->first()->PedidoItem->quantidade);
    }

    /**
     * @test
     */
    public function it_belongs_to_a_pedido_status()
    {
        // Arrange: Create a PedidoStatus and an associated Pedido
        $pedidoStatus = factory(PedidoStatus::class)->create();
        $pedido = factory(Pedido::class)->create(['id_pedido_status' => $pedidoStatus->id]);

        // Act: Retrieve the related PedidoStatus
        $foundPedidoStatus = $pedido->PedidoStatus;

        // Assert: Check if the relationship returns the correct PedidoStatus
        $this->assertInstanceOf('App\\PedidoStatus', $foundPedidoStatus);
        $this->assertEquals($pedidoStatus->id, $foundPedidoStatus->id);
    }

    /**
     * @test
     */
    public function it_belongs_to_a_cliente()
    {
        // Arrange: Create a Cliente and an associated Pedido
        $cliente = factory(Cliente::class)->create();
        $pedido = factory(Pedido::class)->create(['id_cliente' => $cliente->id]);

        // Act: Retrieve the related Cliente
        $foundCliente = $pedido->Cliente;

        // Assert: Check if the relationship returns the correct Cliente
        $this->assertInstanceOf('App\\Cliente', $foundCliente);
        $this->assertEquals($cliente->id, $foundCliente->id);
    }

    /**
     * @test
     */
    public function id_usuario_update_attribute_can_be_null()
    {
        // Arrange: Create a Pedido with null id_usuario_update
        $pedido = factory(Pedido::class)->create([
            'id_usuario_update' => null,
        ]);

        // Act: Retrieve the Pedido from the database
        $foundPedido = Pedido::find($pedido->id);

        // Assert: Check if id_usuario_update is null
        $this->assertNull($foundPedido->id_usuario_update);
    }

    /**
     * @test
     */
    public function id_usuario_update_attribute_can_be_set()
    {
        // Arrange: Create a User and a Pedido with id_usuario_update
        $user = factory(\App\User::class)->create();
        $pedido = factory(Pedido::class)->create([
            'id_usuario_update' => $user->id,
        ]);

        // Act: Retrieve the Pedido from the database
        $foundPedido = Pedido::find($pedido->id);

        // Assert: Check if id_usuario_update is set correctly
        $this->assertEquals($user->id, $foundPedido->id_usuario_update);
    }
}
