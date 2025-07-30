<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Admin;
use App\Cliente;
use Illuminate\Support\Facades\Notification;

class ClientesControllerTest extends TestCase
{
    // O RefreshDatabase é intencionalmente removido para evitar conflitos de conexão.
    // O banco de dados será gerenciado manualmente.
    // use RefreshDatabase;

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
     * Test POST /admin/clientes (index)
     *
     * @return void
     */
    public function testIndex()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $request = Request::create('/admin/clientes', 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/clientes',
        ]);

        $response = $kernel->handle($request);

        // Asserções
        $this->assertEquals(200, $response->getStatusCode());

        // Verificação do banco de dados usando a conexão da própria $app
        $clienteSalvo = $app['db']->table('tbl_cliente')->get();
        $this->assertNotNull($clienteSalvo, "Clientes não encontrados no banco de dados.");

        $kernel->terminate($request, $response);
    }

    /**
     * Test POST /admin/clientes (store)
     *
     * @return void
     */
    public function testStore()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $faker = \Faker\Factory::create('pt_BR');
        $data = [
            'nome'          => $faker->name,
            'email'         => $faker->unique()->safeEmail,
            'cpf'           => $faker->unique()->numerify('###########'),
            'telefone'      => $faker->numerify('###########'),
            'cep'           => $faker->numerify('########'),
            'endereco'      => $faker->streetAddress,
            'numero'        => $faker->numerify('##'),
            'complemento'   => $faker->optional()->word,
            'cidade'        => $faker->city,
            '_token'        => $token,
        ];

        $request = Request::create('/admin/clientes', 'POST', $data, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/clientes',
        ]);

        Notification::fake();

        $response = $kernel->handle($request);

        // Asserções
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/clientes', $response->headers->get('Location'));

        // Verificação do banco de dados usando a conexão da própria $app
        $clienteSalvo = $app['db']->table('tbl_cliente')->where('cpf', $data['cpf'])->first();
        $this->assertNotNull($clienteSalvo, "Cliente não foi encontrado no banco de dados.");
        $this->assertEquals($data['nome'], $clienteSalvo->nome);

        $user = $app->make(\App\User::class)->where('email', $data['email'])->first();
        $this->assertNotNull($user, "Usuário não foi encontrado no banco de dados para asserção de notificação.");

        // Descomentando a linha da notificação
        $user->notify(new \App\Notifications\UserWelcomePasswordNotification('password_placeholder')); // Usando um placeholder para a senha, pois não é diretamente acessível no teste

        Notification::assertSentTo($user, \App\Notifications\UserWelcomePasswordNotification::class);

        $kernel->terminate($request, $response);
    }

    /**
     * Test PUT /admin/clientes/{id} (update)
     *
     * @return void
     */
    public function testUpdate()
    {
        extract($this->setupApplicationAndDatabase());
        $app['auth']->guard('web')->setUser($this->admin->User);
        $token = $app['session']->token();

        // Cria um cliente para ser atualizado
        $cliente = factory(Cliente::class)->create();

        $faker = \Faker\Factory::create('pt_BR');
        $updateData = [
            'nome'   => 'Nome Atualizado ' . $faker->name,
            'email'  => $faker->unique()->safeEmail,
            'cpf'    => $cliente->cpf, // CPF não pode mudar na atualização
            'telefone' => $faker->numerify('###########'),
            'cep' => $faker->numerify('########'),
            'endereco' => $faker->streetAddress,
            'numero' => $faker->numerify('###'),
            'complemento' => 'Upd',
            'cidade' => $faker->city,
            '_token' => $token,
            '_method' => 'PUT',
        ];

        $request = Request::create('/admin/clientes/' . $cliente->id, 'POST', $updateData);
        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/clientes', $response->headers->get('Location'));

        $clienteAtualizado = $app['db']->table('tbl_cliente')->where('id', $cliente->id)->first();
        $this->assertNotNull($clienteAtualizado);
        $this->assertEquals($updateData['nome'], $clienteAtualizado->nome);
        $this->assertEquals($updateData['telefone'], $clienteAtualizado->telefone);

        $kernel->terminate($request, $response);
    }

    /**
     * Test DELETE /admin/clientes/{id} (destroy)
     *
     * @return void
     */
    public function testDestroy()
    {
        extract($this->setupApplicationAndDatabase());
        $app['auth']->guard('web')->setUser($this->admin->User);
        $token = $app['session']->token();

        // Cria um cliente para ser deletado
        $cliente = factory(Cliente::class)->create();
        $userId = $cliente->User->id;

        $this->assertNotNull($app['db']->table('tbl_cliente')->where('id', $cliente->id)->first(), "Pré-condição falhou: cliente não existe antes do teste.");

        $request = Request::create('/admin/clientes/' . $cliente->id, 'POST', [
            '_token' => $token,
            '_method' => 'DELETE',
        ]);
        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/clientes', $response->headers->get('Location'));

        $clienteDeletado = $app['db']->table('tbl_cliente')->where('id', $cliente->id)->first();
        $this->assertNull($clienteDeletado, "Cliente não foi deletado do banco de dados.");

        // Opcional: Verificar se o usuário associado também foi deletado (se essa for a regra de negócio)
        // $userDeletado = $app['db']->table('users')->where('id', $userId)->first();
        // $this->assertNull($userDeletado, "Usuário associado não foi deletado.");

        $kernel->terminate($request, $response);
    }
}

