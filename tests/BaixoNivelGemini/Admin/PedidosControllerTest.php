<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Pedido;
use App\Cliente;
use App\Produto;

class PedidosControllerTest extends TestCase
{
    // use RefreshDatabase; // Usaremos migrate:fresh e db:seed manualmente

    private $admin;

    /**
     * Helper method to set up application and database for each test.
     *
     * @return array
     */
    protected function setupApplicationAndDatabase()
    {
        $app = $this->createApplication();
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        // Garante um banco de dados limpo para cada teste
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--force' => true]);

        // Pega o admin do banco de dados recém-semeado
        $this->admin = $app->make(Admin::class)->first();

        return ['app' => $app, 'kernel' => $kernel];
    }

    /**
     * Test GET /admin/pedidos (index).
     *
     * @return void
     */
    public function testIndex()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $request = Request::create('/admin/pedidos', 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/pedidos',
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Pedidos', $response->getContent());

        $kernel->terminate($request, $response);
    }

    /**
     * Test POST /admin/pedidos (store).
     *
     * @return void
     */
    public function testStore()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $cliente = factory(Cliente::class)->create();
        $produto = factory(Produto::class)->create();

        $data = [
            'cliente' => $cliente->id,
            $produto->id => ['quantidade' => 1, 'valor' => $produto->valor],
            '_token' => $token,
        ];

        $request = Request::create('/admin/pedidos', 'POST', $data, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/pedidos',
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/pedidos', $response->headers->get('Location'));
        
        $database = $app->make('db');
        $this->assertTrue($database->table('tbl_pedido')->where('id_cliente', $cliente->id)->exists());
        $pedido = $database->table('tbl_pedido')->where('id_cliente', $cliente->id)->first();
        $this->assertTrue($database->table('tbl_pedido_item')->where([
            'id_pedido' => $pedido->id,
            'id_produto' => $produto->id,
            'quantidade' => 1,
        ])->exists());

        $kernel->terminate($request, $response);
    }

    /**
     * Test GET /admin/pedidos/{id} (show).
     *
     * @return void
     */
    public function testShow()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $pedido = factory(Pedido::class)->create();

        $request = Request::create('/admin/pedidos/' . $pedido->id, 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/pedidos/' . $pedido->id,
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString((string)$pedido->id, $response->getContent()); // Assumindo que o ID do pedido é exibido

        $kernel->terminate($request, $response);
    }

    /**
     * Test PUT /admin/pedidos/{id} (update).
     *
     * @return void
     */
    public function testUpdate()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $pedido = factory(Pedido::class)->create();
        $produto = factory(Produto::class)->create();
        $pedido->Produtos()->attach($produto->id, ['valor' => 10.00, 'quantidade' => 1]);

        $updateData = [
            $produto->id => ['quantidade' => 2, 'valor' => $produto->valor],
            '_token' => $token,
            '_method' => 'PUT',
        ];

        $request = Request::create('/admin/pedidos/' . $pedido->id, 'POST', $updateData, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/pedidos/' . $pedido->id,
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/pedidos', $response->headers->get('Location'));

        $database = $app->make('db');
        $this->assertTrue($database->table('tbl_pedido_item')->where([
            'id_pedido' => $pedido->id,
            'id_produto' => $produto->id,
            'quantidade' => 2,
        ])->exists());

        $kernel->terminate($request, $response);
    }

    /**
     * Test DELETE /admin/pedidos/{id} (destroy).
     *
     * @return void
     */
    public function testDestroy()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $pedido = factory(Pedido::class)->create();

        $request = Request::create('/admin/pedidos/' . $pedido->id, 'POST', [
            '_token' => $token,
            '_method' => 'DELETE',
        ], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/pedidos/' . $pedido->id,
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/pedidos', $response->headers->get('Location'));
        
        $database = $app->make('db');
        $this->assertTrue($database->table('tbl_pedido')->where([
            'id' => $pedido->id,
            'id_pedido_status' => 6, // Cancelado
        ])->exists());

        $kernel->terminate($request, $response);
    }
}
