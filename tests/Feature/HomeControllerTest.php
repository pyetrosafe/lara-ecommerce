<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the home page can be accessed.
     *
     * @return void
     */
    public function testMigrateRouteAccess()
    {
        $response = $this->get('/migrate');
        $response->assertStatus(200);
        $response->assertSee('Migrate conclúido!');
    }
}
