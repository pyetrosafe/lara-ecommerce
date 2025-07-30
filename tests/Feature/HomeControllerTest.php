<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the migrate route.
     *
     * @return void
     */
    public function testMigrateRouteAccess()
    {
        $response = $this->get('/migrate');

        $response->assertStatus(200);
        $response->assertSee('Migrate concluído!');
    }

    /**
     * Test the index page can be accessed.
     *
     * @return void
     */
    public function testIndexPageAccess()
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('As Melhores Ofertas');
    }

    /**
     * Test the home page can be accessed.
     *
     * @return void
     */
    public function testHomePageAccess()
    {
        $this->seed();

        $response = $this->get('/home');

        $response->assertStatus(200);
        $response->assertSee('As Melhores Ofertas');
    }
}
