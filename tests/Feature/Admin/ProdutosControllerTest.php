<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Produto;

class ProdutosControllerTest extends TestCase
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
     * Test GET /admin/produtos (index).
     *
     * @return void
     */
    public function testIndex()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $request = Request::create('/admin/produtos', 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/produtos',
        ]);

        $response = $kernel->handle($request);

        // Asserções
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Produtos', $response->getContent());

        // Verificação do banco de dados usando a conexão da própria $app
        $produtos = $app['db']->table('tbl_produto')->get();
        $this->assertNotNull($produtos, "Produtos não encontrados no banco de dados.");

        $kernel->terminate($request, $response);
    }

    /**
     * Test POST /admin/produtos (store).
     *
     * @return void
     */
    public function testStore()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        // Cria um produto usando o factory
        $data = factory(Produto::class)->make()->toArray();

        $request = Request::create('/admin/produtos', 'POST', $data, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/produtos',
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/produtos', $response->headers->get('Location'));

        $produtoSalvo = $app['db']->table('tbl_produto')->where('nome', $data['nome'])->first();
        $this->assertNotNull($produtoSalvo);

        $this->assertEquals($produtoSalvo->nome, $data['nome']);
        $this->assertEquals($produtoSalvo->descricao, $data['descricao']);

        $kernel->terminate($request, $response);
    }

    /**
     * Test GET /admin/produtos/{id} (show).
     *
     * @return void
     */
    public function testShow()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $produto = factory(Produto::class)->create();

        $request = Request::create('/admin/produtos/' . $produto->id, 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/produtos/' . $produto->id,
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString($produto->nome, $response->getContent()); // Assumindo que o nome do produto é exibido

        $kernel->terminate($request, $response);
    }

    /**
     * Test PUT /admin/produtos/{id} (update).
     *
     * @return void
     */
    public function testUpdate()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $produto = factory(Produto::class)->create();
        $faker = \Faker\Factory::create('pt_BR');

        $updateData = [
            'nome' => 'Produto Atualizado ' . $faker->word,
            'descricao' => $faker->paragraph,
            'valor' => $faker->randomFloat(2, 10, 1000),
            'quantidade' => $faker->numberBetween(1, 100),
            '_token' => $token,
            '_method' => 'PUT',
        ];

        $request = Request::create('/admin/produtos/' . $produto->id, 'POST', $updateData, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/produtos/' . $produto->id,
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/produtos', $response->headers->get('Location'));

        $produtoSalvo = $app['db']->table('tbl_produto')->where('id', $produto->id)->first();
        $this->assertNotNull($produtoSalvo);
        $this->assertEquals($produtoSalvo->id, $produto->id);
        $this->assertEquals($produtoSalvo->nome, $updateData['nome']);
        $this->assertEquals($produtoSalvo->descricao, $updateData['descricao']);

        $kernel->terminate($request, $response);
    }

    /**
     * Test DELETE /admin/produtos/{id} (destroy).
     *
     * @return void
     */
    public function testDestroy()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $produto = factory(Produto::class)->create();

        $request = Request::create('/admin/produtos/' . $produto->id, 'POST', [
            '_token' => $token,
            '_method' => 'DELETE',
        ], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/produtos/' . $produto->id,
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/produtos', $response->headers->get('Location'));

        $produtoSalvo = $app['db']->table('tbl_produto')->where('id', $produto->id)->first();
        $this->assertNull($produtoSalvo, "Produto ainda existe no banco de dados após exclusão.");

        $kernel->terminate($request, $response);
    }

    /**
     * Test GET /admin/ajax/produtos (ajaxSearch).
     *
     * @return void
     */
    public function testAjaxSearch()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $produto1 = factory(Produto::class)->create(['nome' => 'Teclado Gamer']);
        $produto2 = factory(Produto::class)->create(['nome' => 'Mouse Gamer']);

        $request = Request::create('/admin/ajax/produtos', 'GET', ['produto' => 'Teclado'], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/produtos',
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString($produto1->nome, $response->getContent());
        $this->assertStringNotContainsString($produto2->nome, $response->getContent());

        $kernel->terminate($request, $response);
    }
}
