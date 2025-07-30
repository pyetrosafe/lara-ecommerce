<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

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
        $app = $this->createApplication();
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        $request = Request::create('/migrate', 'GET');
        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Migrate concluído!', $response->getContent());

        $kernel->terminate($request, $response);
    }

    /**
     * Test the index page can be accessed.
     *
     * @return void
     */
    public function testIndexPageAccess()
    {
        $app = $this->createApplication();
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--force' => true]);

        $request = Request::create('/', 'GET');
        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('As Melhores Ofertas', $response->getContent());

        $kernel->terminate($request, $response);
    }

    /**
     * Test the home page can be accessed.
     *
     * @return void
     */
    public function testHomePageAccess()
    {
        $app = $this->createApplication();
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--force' => true]);

        $request = Request::create('/home', 'GET');
        $response = $kernel->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('As Melhores Ofertas', $response->getContent());

        $kernel->terminate($request, $response);
    }
}
