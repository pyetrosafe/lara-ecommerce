<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Cliente;
use App\User;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_cliente()
    {
        // Arrange: Create a cliente instance using the factory
        $cliente = factory(Cliente::class)->create();

        // Assert: Check if the cliente exists in the database
        $this->assertDatabaseHas('tbl_cliente', [
            'id' => $cliente->id,
            'nome' => $cliente->nome,
        ]);
    }

    /**
     * @test
     */
    public function cliente_attributes_are_set_correctly()
    {
        // Arrange: Create a user and then a cliente with specific data
        $user = factory(User::class)->create();
        $cliente = factory(Cliente::class)->create([
            'id_usuario' => $user->id,
            'nome' => 'Cliente Teste',
            'cpf' => '12345678901',
            'telefone' => '11987654321',
            'endereco' => 'Rua Teste, 123',
            'numero' => '123',
            'cep' => '12345678',
            'cidade' => 'Cidade Teste',
        ]);

        // Act: Retrieve the cliente from the database
        $foundCliente = Cliente::find($cliente->id);

        // Assert: Check if the attributes are correct
        $this->assertEquals('Cliente Teste', $foundCliente->nome);
        $this->assertEquals('123.456.789-01', $foundCliente->cpf); // Masked CPF
        $this->assertEquals('(11) 98765-4321', $foundCliente->telefone); // Masked Phone
        $this->assertEquals('Rua Teste, 123', $foundCliente->endereco);
        $this->assertEquals('123', $foundCliente->numero);
        $this->assertEquals('12345678', $foundCliente->cep);
        $this->assertEquals('Cidade Teste', $foundCliente->cidade);
        $this->assertEquals($user->id, $foundCliente->id_usuario);
    }

    /**
     * @test
     */
    public function cliente_complemento_attribute_can_be_null()
    {
        // Arrange: Create a cliente with null complemento
        $cliente = factory(Cliente::class)->create([
            'complemento' => null,
        ]);

        // Act: Retrieve the cliente from the database
        $foundCliente = Cliente::find($cliente->id);

        // Assert: Check if complemento is null
        $this->assertNull($foundCliente->complemento);
    }

    /**
     * @test
     */
    public function it_belongs_to_a_user()
    {
        // Arrange: Create a User and an associated Cliente
        $user = factory(User::class)->create();
        $cliente = factory(Cliente::class)->create(['id_usuario' => $user->id]);

        // Act: Retrieve the related User
        $foundUser = $cliente->User;

        // Assert: Check if the relationship returns the correct User
        $this->assertInstanceOf('App\\User', $foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }
}
