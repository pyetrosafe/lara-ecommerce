<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Admin;
use App\User;

class GraficoControllerTest extends TestCase
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
     * Test GET /admin/grafico (index).
     *
     * @return void
     */
    public function testIndexGet()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $request = Request::create('/admin/grafico', 'GET', [], [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/grafico',
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/grafico', $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }

    /**
     * Test POST /admin/grafico (index - with filter data).
     *
     * @return void
     */
    public function testIndexPost()
    {
        extract($this->setupApplicationAndDatabase());

        // Autentica o usuário na instância da app
        $app['auth']->guard('web')->setUser($this->admin->User);

        $token = $app['session']->token();

        $filterData = [
            'startDt' => '2023-01-01',
            'endDt' => '2023-12-31',
            '_token' => $token,
        ];

        $request = Request::create('/admin/grafico', 'POST', $filterData, [], [], [
            'HTTP_X-CSRF-TOKEN' => $token,
            'HTTP_REFERER' => '/admin/grafico',
        ]);

        $response = $kernel->handle($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/admin/grafico', $response->headers->get('Location'));

        $kernel->terminate($request, $response);
    }
}
