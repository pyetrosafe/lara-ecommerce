<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Cliente;
use App\Pedido;
use App\Produto;
use App\PedidoStatus;

class HistoricoPedidosControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /historico (index).
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create(['email_verified_at' => now()]);
        factory(Cliente::class)->create(['id_usuario' => $user->id]);

        // Test GET
        $responseGet = $this->actingAs($user)->get('/historico');
        $responseGet->assertStatus(200);
        $responseGet->assertViewIs('historico');
        $responseGet->assertSee('Histórico de Pedidos');
    }

    /**
     * Test POST /historico (index).
     *
     * @return void
     */
    public function testPost()
    {
        $user = factory(User::class)->create(['email_verified_at' => now()]);
        factory(Cliente::class)->create(['id_usuario' => $user->id]);

        // Test POST
        $responsePost = $this->actingAs($user)->post('/historico', ['startDt' => '2023-01-01', 'endDt' => '2023-12-31']);
        $responsePost->assertStatus(200);
        $responsePost->assertViewIs('historico');
        $responsePost->assertSee('Histórico de Pedidos');
    }

    /**
     * Test GET /historico/{id} (show).
     *
     * @return void
     */
    public function testShow()
    {
        factory(PedidoStatus::class)->create(['id' => 1, 'descricao' => 'Aguardando Pagamento']);
        factory(PedidoStatus::class)->create(['id' => 7, 'descricao' => 'Em Aberto (cliente)']);
        $user = factory(User::class)->create();
        $cliente = factory(Cliente::class)->create(['id_usuario' => $user->id]);
        $pedido = factory(Pedido::class)->create(['id_cliente' => $cliente->id, 'id_pedido_status' => 1]);

        $response = $this->actingAs($user)->get('/historico/' . $pedido->id);

        $response->assertStatus(200);
        $response->assertViewIs('historico');
        $response->assertViewHas('action', 'alteracao');
    }

    /**
     * Test PUT /historico/{id} (update).
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $cliente = factory(Cliente::class)->create(['id_usuario' => $user->id]);
        $pedido = factory(Pedido::class)->create(['id_cliente' => $cliente->id]);
        $produto = factory(Produto::class)->create();
        $pedido->Produtos()->attach($produto->id, ['valor' => 10.00, 'quantidade' => 1]);

        $updateData = [
            $produto->id => [
                'quantidade' => 2,
                'valor' => 10.00
            ]
        ];

        $response = $this->actingAs($user)->put('/historico/' . $pedido->id, $updateData);

        $response->assertRedirect('/historico');
        $this->assertDatabaseHas('tbl_pedido_item', [
            'id_pedido' => $pedido->id,
            'id_produto' => $produto->id,
            'quantidade' => 2,
        ]);
    }
}
