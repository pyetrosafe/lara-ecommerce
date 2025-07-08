<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\User;
use App\Pedido;
use App\Produto;

class HistoricoPedidosControllerTest extends TestCase
{
    // O RefreshDatabase é intencionalmente removido para evitar conflitos de conexão.
    // O banco de dados será gerenciado manualmente.
    // use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Nota: withoutMiddleware(VerifyCsrfToken::class) pode não funcionar em todos os ambientes
        // para requisições de baixo nível. Se o teste falhar com 419, pode ser necessário
        // adicionar um token CSRF manualmente à requisição ou desabilitar o middleware de outra forma.
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
     * Test GET /historico and POST /historico (index).
     *
     * @return void
     */
    public function testIndex()
    {
        extract($this->setupApplicationAndDatabase());

        // Criar um usuário e um cliente associado, e marcar o usuário como verificado
        $user = factory(User::class)->create(['email_verified_at' => now()]);
        factory(\App\Cliente::class)->create(['id_usuario' => $user->id]);

        // Simular a autenticação do usuário na instância da aplicação
        $app['auth']->guard()->setUser($user);

        // Testar GET /historico
        $requestGet = Request::create('/historico', 'GET');
        $responseGet = $kernel->handle($requestGet);

        $this->assertEquals(200, $responseGet->getStatusCode());
        $this->assertStringContainsString('Histórico de Pedidos', $responseGet->getContent());

        $kernel->terminate($requestGet, $responseGet);

        // Testar POST /historico (com dados de filtro, se aplicável)
        $requestPost = Request::create('/historico', 'POST', ['startDt' => '2023-01-01', 'endDt' => '2023-12-31']);
        $responsePost = $kernel->handle($requestPost);

        $this->assertEquals(200, $responsePost->getStatusCode());
        $this->assertStringContainsString('Histórico de Pedidos', $responsePost->getContent());

        $kernel->terminate($requestPost, $responsePost);
    }

    /**
     * Test GET /historico/{id} (show).
     *
     * @return void
     */
    public function testShow()
    {
        extract($this->setupApplicationAndDatabase());

        // Criar um usuário, cliente e um pedido associado
        $user = factory(User::class)->create();
        $cliente = factory(\App\Cliente::class)->create(['id_usuario' => $user->id]);
        $pedido = factory(Pedido::class)->create(['id_cliente' => $cliente->id]);

        // Simular a autenticação do usuário
        $app['auth']->guard()->setUser($user);

        $token = $app['session']->token();

        $request = Request::create('/historico/' . $pedido->id, 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => url('/historico/' . $pedido->id),
        ]);
        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/historico/' . $pedido->id, $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }

    /**
     * Test PUT /historico/{id} (update).
     *
     * @return void
     */
    public function testUpdate()
    {
        extract($this->setupApplicationAndDatabase());

        // Criar um usuário, cliente e um pedido associado
        $user = factory(User::class)->create();
        $cliente = factory(\App\Cliente::class)->create(['id_usuario' => $user->id]);
        $pedido = factory(Pedido::class)->create(['id_cliente' => $cliente->id]);

        // Simular a autenticação do usuário
        $app['auth']->guard()->setUser($user);

        // Dados para atualização (ex: um item de produto no pedido)
        $produto = factory(Produto::class)->create();
        $pedido->Produtos()->attach($produto->id, ['valor' => 10.00, 'quantidade' => 1]);

        $updateData = [
            '_method' => 'PUT', // Laravel expects this for PUT requests
            $produto->id => [
                'quantidade' => 2,
                'valor' => 10.00
            ]
        ];

        // Gerar um token CSRF válido
        $token = $app['session']->token();

        $updateData['_token'] = $token;

        $request = Request::create('/historico/' . $pedido->id, 'POST', $updateData, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => url('/historico/' . $pedido->id),
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode()); // Espera um redirecionamento
        $this->assertStringContainsString('/historico', $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }
}
