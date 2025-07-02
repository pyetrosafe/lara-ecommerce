<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Admin;
use App\User;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_an_admin()
    {
        // Arrange: Create an admin instance using the factory
        $admin = factory(Admin::class)->create();

        // Assert: Check if the admin exists in the database
        $this->assertDatabaseHas('tbl_admin', [
            'id' => $admin->id,
            'nome' => $admin->nome,
        ]);
    }

    /**
     * @test
     */
    public function admin_attributes_are_set_correctly()
    {
        // Arrange: Create a user and then an admin with specific data
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create([
            'id_usuario' => $user->id,
            'nome' => 'Admin User Test',
        ]);

        // Act: Retrieve the admin from the database
        $foundAdmin = Admin::find($admin->id);

        // Assert: Check if the attributes are correct
        $this->assertEquals('Admin User Test', $foundAdmin->nome);
        $this->assertEquals($user->id, $foundAdmin->id_usuario);
    }

    /**
     *
     * @test
     */
    public function it_belongs_to_a_user()
    {
        // Arrange: Create a User and an associated Admin
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create(['id_usuario' => $user->id]);

        // Act: Retrieve the related User
        $foundUser = $admin->user;

        // Assert: Check if the relationship returns the correct User
        $this->assertInstanceOf('App\\User', $foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }
}
