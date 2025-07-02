<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\PedidoStatus;

class PedidoStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_pedido_status()
    {
        // Arrange: Create a PedidoStatus instance using the factory
        $pedidoStatus = factory(PedidoStatus::class)->create();

        // Assert: Check if the PedidoStatus exists in the database
        $this->assertDatabaseHas('tbl_pedido_status', [
            'id' => $pedidoStatus->id,
            'descricao' => $pedidoStatus->descricao,
        ]);
    }

    /**
     * @test
     */
    public function pedido_status_attributes_are_set_correctly()
    {
        // Arrange: Create a PedidoStatus with specific data
        $pedidoStatus = factory(PedidoStatus::class)->create([
            'descricao' => 'Status Teste',
        ]);

        // Act: Retrieve the PedidoStatus from the database
        $foundPedidoStatus = PedidoStatus::find($pedidoStatus->id);

        // Assert: Check if the attributes are correct
        $this->assertEquals('Status Teste', $foundPedidoStatus->descricao);
    }

    /**
     * @test
     */
    public function it_has_many_pedidos()
    {
        // Arrange: Create a PedidoStatus and associated Pedidos
        $pedidoStatus = factory(PedidoStatus::class)->create();
        $pedidos = factory(\App\Pedido::class, 3)->create(['id_pedido_status' => $pedidoStatus->id]);

        // Act: Retrieve the related Pedidos
        $foundPedidos = $pedidoStatus->Pedido;

        // Assert: Check if the relationship returns the correct number of Pedidos
        $this->assertCount(3, $foundPedidos);
        $this->assertInstanceOf('App\\Pedido', $foundPedidos->first());
        $this->assertEquals($pedidoStatus->id, $foundPedidos->first()->id_pedido_status);
    }
}
