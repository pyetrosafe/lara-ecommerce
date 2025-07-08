<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Produto;

class CarrinhoCompraControllerTest extends TestCase
{
    // O RefreshDatabase é intencionalmente removido para evitar conflitos de conexão.
    // O banco de dados será gerenciado manualmente.
    // use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /**
     * Helper method to set up application and database.
     *
     * @return array
     */
    protected function setupApplicationAndDatabase()
    {
        $app = $this->createApplication();
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--force' => true]);

        return ['app' => $app, 'kernel' => $kernel];
    }

    /**
     * Test GET /carrinho (showCart).
     *
     * @return void
     */
    public function testShowCart()
    {
        extract($this->setupApplicationAndDatabase());

        $request = Request::create('/carrinho', 'GET');
        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Meu Carrinho', $response->getContent());

        $kernel->terminate($request, $response);
    }

    /**
     * Test GET /carrinho/{productId} (addCart).
     *
     * @return void
     */
    public function testAddCart()
    {
        extract($this->setupApplicationAndDatabase());

        $produto = factory(Produto::class)->create();

        $request = Request::create('/carrinho/' . $produto->id, 'GET');
        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/carrinho', $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }

    /**
     * Test PUT /carrinho/{productId} (updateCart).
     *
     * @return void
     */
    public function testUpdateCart()
    {
        extract($this->setupApplicationAndDatabase());

        $produto = factory(Produto::class)->create();
        // Simular a adição do produto ao carrinho para que possa ser atualizado
        $addRequest = Request::create('/carrinho/' . $produto->id, 'GET');
        $kernel->handle($addRequest);

        $request = Request::create('/carrinho/' . $produto->id, 'PUT', ['quantidade' => 2], [], [], ['HTTP_X-CSRF-TOKEN' => 'dummy_token']);
        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/carrinho', $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }

    /**
     * Test DELETE /carrinho/{productId} (deleteCart).
     *
     * @return void
     */
    public function testDeleteCart()
    {
        extract($this->setupApplicationAndDatabase());

        $produto = factory(Produto::class)->create();
        // Simular a adição do produto ao carrinho para que possa ser removido
        $addRequest = Request::create('/carrinho/' . $produto->id, 'GET');
        $kernel->handle($addRequest);

        $request = Request::create('/carrinho/' . $produto->id, 'DELETE', [], [], [], ['HTTP_X-CSRF-TOKEN' => 'dummy_token']);
        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/carrinho', $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }
}
