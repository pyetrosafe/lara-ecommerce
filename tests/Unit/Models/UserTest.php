<?php

namespace Tests\Unit\Models;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_a_user()
    {
        // Arrange: Create a user instance using the factory
        $user = factory(User::class)->create();

        // Assert: Check if the user exists in the database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    /**
     * @test
     */
    public function user_attributes_are_set_correctly()
    {
        // Arrange: Create a user with specific data
        $user = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Act: Retrieve the user from the database
        $foundUser = User::find($user->id);

        // Assert: Check if the attributes are correct
        $this->assertEquals('John Doe', $foundUser->name);
        $this->assertEquals('john.doe@example.com', $foundUser->email);
        $this->assertTrue(password_verify('password123', $foundUser->password));
    }

    /**
     * @test
     */
    public function it_has_one_admin()
    {
        // Arrange: Create a User and an associated Admin
        $user = factory(User::class)->create();
        $admin = factory(\App\Admin::class)->create(['id_usuario' => $user->id]);

        // Act: Retrieve the related Admin
        $foundAdmin = $user->Admin;

        // Assert: Check if the relationship returns the correct Admin
        $this->assertInstanceOf('App\\Admin', $foundAdmin);
        $this->assertEquals($admin->id, $foundAdmin->id);
        $this->assertEquals($user->id, $foundAdmin->id_usuario);
    }

    /**
     * @test
     */
    public function it_has_one_cliente()
    {
        // Arrange: Create a User and an associated Cliente
        $user = factory(User::class)->create();
        $cliente = factory(\App\Cliente::class)->create(['id_usuario' => $user->id]);

        // Act: Retrieve the related Cliente
        $foundCliente = $user->Cliente;

        // Assert: Check if the relationship returns the correct Cliente
        $this->assertInstanceOf('App\\Cliente', $foundCliente);
        $this->assertEquals($cliente->id, $foundCliente->id);
        $this->assertEquals($user->id, $foundCliente->id_usuario);
    }

    /**
     * @test
     */
    public function it_can_check_if_user_is_admin()
    {
        // Arrange: Create a regular user
        $user = factory(User::class)->create(['admin' => false]);

        // Assert: Regular user is not admin
        $this->assertFalse($user->isAdmin());

        // Arrange: Create an admin user
        $adminUser = factory(User::class)->create(['admin' => true]);

        // Assert: Admin user is admin
        $this->assertTrue($adminUser->isAdmin());
    }
}
