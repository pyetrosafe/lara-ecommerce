<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Admin;
use App\Produto;

class ProdutosControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(Admin::class)->create();
    }

    /**
     * Test GET /admin/produtos (index).
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/produtos');

        $response->assertStatus(200);
        $response->assertViewIs('admin.produtos');
        $response->assertSee('Produtos');
    }

    /**
     * Test POST /admin/produtos (store).
     *
     * @return void
     */
    public function testStore()
    {
        $data = factory(Produto::class)->make()->toArray();

        $response = $this->actingAs($this->admin->User, 'web')
                         ->post('/admin/produtos', $data);

        $response->assertRedirect('/admin/produtos');
        $this->assertDatabaseHas('tbl_produto', ['nome' => $data['nome']]);
    }

    /**
     * Test GET /admin/produtos/{id} (show).
     *
     * @return void
     */
    public function testShow()
    {
        $produto = factory(Produto::class)->create();

        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/produtos/' . $produto->id);

        $response->assertStatus(200);
        $response->assertViewIs('admin.produtos');
        $response->assertSee($produto->nome);
    }

    /**
     * Test PUT /admin/produtos/{id} (update).
     *
     * @return void
     */
    public function testUpdate()
    {
        $produto = factory(Produto::class)->create();
        
        $updateData = [
            'nome' => 'Produto Atualizado ' . $this->faker->word,
            'descricao' => $this->faker->paragraph,
            'valor' => $this->faker->randomFloat(2, 10, 1000),
            'quantidade' => $this->faker->numberBetween(1, 100),
        ];

        $response = $this->actingAs($this->admin->User, 'web')
                         ->put('/admin/produtos/' . $produto->id, $updateData);

        $response->assertRedirect('/admin/produtos');
        $this->assertDatabaseHas('tbl_produto', [
            'id' => $produto->id,
            'nome' => $updateData['nome'],
        ]);
    }

    /**
     * Test DELETE /admin/produtos/{id} (destroy).
     *
     * @return void
     */
    public function testDestroy()
    {
        $produto = factory(Produto::class)->create();

        $response = $this->actingAs($this->admin->User, 'web')
                         ->delete('/admin/produtos/' . $produto->id);

        $response->assertRedirect('/admin/produtos');
        $this->assertDatabaseMissing('tbl_produto', ['id' => $produto->id]);
    }

    /**
     * Test GET /admin/ajax/produtos (ajaxSearch).
     *
     * @return void
     */
    public function testAjaxSearch()
    {
        $produto1 = factory(Produto::class)->create(['nome' => 'Teclado Gamer']);
        $produto2 = factory(Produto::class)->create(['nome' => 'Mouse Gamer']);

        $response = $this->actingAs($this->admin->User, 'web')
                         ->get('/admin/ajax/produtos?produto=Teclado');

        $response->assertStatus(200);
        $response->assertSee($produto1->nome);
        $response->assertDontSee($produto2->nome);
    }
}
