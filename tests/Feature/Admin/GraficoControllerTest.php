<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Admin;

class GraficoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(Admin::class)->create();
    }

    /**
     * Test GET /admin/grafico (index).
     *
     * @return void
     */
    public function testIndexGet()
    {
        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/grafico');

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test POST /admin/grafico (index - with filter data).
     *
     * @return void
     */
    public function testIndexPost()
    {
        $filterData = [
            'startDt' => '2023-01-01',
            'endDt' => '2023-12-31',
        ];

        $response = $this->actingAs($this->admin->User, 'web')
                         ->post('/admin/grafico', $filterData);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('error');
    }
}
