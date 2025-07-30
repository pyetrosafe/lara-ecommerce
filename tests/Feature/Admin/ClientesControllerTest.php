<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Admin;
use App\Cliente;
use App\User;

class ClientesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user for all tests
        $this->admin = factory(Admin::class)->create();
    }

    /**
     * Test GET /admin/clientes (index)
     *
     * @return void
     */
    public function testIndex()
    {
        // Create some clients to see on the list
        factory(Cliente::class, 3)->create();

        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/clientes');

        $response->assertStatus(200);
        $response->assertViewIs('admin.clientes');
        $response->assertSee('Clientes');
    }

    /**
     * Test POST /admin/clientes (store)
     *
     * @return void
     */
    public function testStore()
    {
        Notification::fake();

        $data = [
            'nome'          => $this->faker->name,
            'email'         => $this->faker->unique()->safeEmail,
            'cpf'           => $this->faker->unique()->numerify('###########'),
            'telefone'      => $this->faker->numerify('###########'),
            'cep'           => $this->faker->numerify('########'),
            'endereco'      => $this->faker->streetAddress,
            'numero'        => $this->faker->numerify('##'),
            'complemento'   => $this->faker->optional()->word,
            'cidade'        => $this->faker->city,
        ];

        $response = $this->actingAs($this->admin->User, 'web')
                         ->post('/admin/clientes', $data);

        $response->assertRedirect('/admin/clientes');
        $this->assertDatabaseHas('tbl_cliente', ['cpf' => $data['cpf']]);

        $user = User::where('email', $data['email'])->first();
        $this->assertNotNull($user);

        Notification::assertSentTo($user, \App\Notifications\UserWelcomePasswordNotification::class);
    }

    /**
     * Test PUT /admin/clientes/{id} (update)
     *
     * @return void
     */
    public function testUpdate()
    {
        $cliente = factory(Cliente::class)->create();

        $updateData = [
            'nome'   => 'Nome Atualizado ' . $this->faker->name,
            'email'  => $this->faker->unique()->safeEmail,
            'cpf'    => $cliente->cpf, // CPF cannot be changed on update
            'telefone' => $this->faker->numerify('###########'),
            'cep' => $this->faker->numerify('########'),
            'endereco' => $this->faker->streetAddress,
            'numero' => $this->faker->numerify('###'),
            'complemento' => 'Upd',
            'cidade' => $this->faker->city,
        ];

        $response = $this->actingAs($this->admin->User, 'web')
                         ->put('/admin/clientes/' . $cliente->id, $updateData);

        $response->assertRedirect('/admin/clientes');
        $this->assertDatabaseHas('tbl_cliente', [
            'id' => $cliente->id,
            'nome' => $updateData['nome'],
            'telefone' => $updateData['telefone'],
        ]);
    }

    /**
     * Test DELETE /admin/clientes/{id} (destroy)
     *
     * @return void
     */
    public function testDestroy()
    {
        $cliente = factory(Cliente::class)->create();
        $userId = $cliente->User->id;

        $response = $this->actingAs($this->admin->User, 'web')
                         ->delete('/admin/clientes/' . $cliente->id);

        $response->assertRedirect('/admin/clientes');
        // $this->assertDatabaseMissing('tbl_cliente', ['id' => $cliente->id]);
        $this->assertSoftDeleted('tbl_cliente', ['id' => $cliente->id]);

        // The current business logic does not delete the associated user.
        // $this->assertDatabaseMissing('users', ['id' => $userId]);
        $this->assertSoftDeleted('users', ['id' => $userId]);
    }
}
