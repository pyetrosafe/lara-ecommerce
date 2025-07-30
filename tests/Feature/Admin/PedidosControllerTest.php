<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Admin;
use App\Cliente;
use App\Pedido;
use App\PedidoStatus;
use App\Produto;

class PedidosControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(Admin::class)->create();
        // The seeder creates the necessary order statuses
        $this->seed('PedidoStatusTableSeeder');
    }

    /**
     * Test GET /admin/pedidos (index).
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/pedidos');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pedidos');
        $response->assertSee('Pedidos');
    }

    /**
     * Test POST /admin/pedidos (store).
     *
     * @return void
     */
    public function testStore()
    {
        $cliente = factory(Cliente::class)->create();
        $produto = factory(Produto::class)->create();

        $data = [
            'cliente' => $cliente->id,
            $produto->id => ['quantidade' => 1, 'valor' => $produto->valor],
        ];

        $response = $this->actingAs($this->admin->User, 'web')
                         ->post('/admin/pedidos', $data);

        $response->assertRedirect('/admin/pedidos');

        $this->assertDatabaseHas('tbl_pedido', ['id_cliente' => $cliente->id]);
        $pedido = Pedido::where('id_cliente', $cliente->id)->first();
        $this->assertDatabaseHas('tbl_pedido_item', [
            'id_pedido' => $pedido->id,
            'id_produto' => $produto->id,
            'quantidade' => 1,
        ]);
    }

    /**
     * Test GET /admin/pedidos/{id} (show).
     *
     * @return void
     */
    public function testShow()
    {
        $pedido = factory(Pedido::class)->create();

        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/pedidos/' . $pedido->id);

        $response->assertStatus(200);
        $response->assertViewIs('admin.pedidos');
        $response->assertSee('Cadastro de Pedidos');
    }

    /**
     * Test PUT /admin/pedidos/{id} (update).
     *
     * @return void
     */
    public function testUpdate()
    {
        $pedido = factory(Pedido::class)->create();
        $produto = factory(Produto::class)->create();
        $pedido->Produtos()->attach($produto->id, ['valor' => 10.00, 'quantidade' => 1]);

        $updateData = [
            $produto->id => ['quantidade' => 2, 'valor' => $produto->valor],
        ];

        $response = $this->actingAs($this->admin->User, 'web')
                         ->put('/admin/pedidos/' . $pedido->id, $updateData);

        $response->assertRedirect('/admin/pedidos');

        $this->assertDatabaseHas('tbl_pedido_item', [
            'id_pedido' => $pedido->id,
            'id_produto' => $produto->id,
            'quantidade' => 2,
        ]);
    }

    /**
     * Test DELETE /admin/pedidos/{id} (destroy).
     *
     * @return void
     */
    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $pedido = factory(Pedido::class)->create();

        $response = $this->actingAs($this->admin->User, 'web')
                         ->delete('/admin/pedidos/' . $pedido->id);

        $response->assertRedirect('/admin/pedidos');

        $this->assertDatabaseHas('tbl_pedido', [
            'id' => $pedido->id,
            'id_pedido_status' => 7, // Cancelado
        ]);
    }
}
