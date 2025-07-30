<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Produto;

class CarrinhoCompraControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /carrinho (showCart).
     *
     * @return void
     */
    public function testShowCart()
    {
        $response = $this->get('/carrinho');

        $response->assertStatus(200);
        $response->assertViewIs('carrinho');
        $response->assertSee('Meu Carrinho');
    }

    /**
     * Test GET /carrinho/{productId} (addCart).
     *
     * @return void
     */
    public function testAddCart()
    {
        $produto = factory(Produto::class)->create();

        $response = $this->get('/carrinho/' . $produto->id);

        $response->assertRedirect('/carrinho');
        $this->assertArrayHasKey($produto->id, session('cart'));
    }

    /**
     * Test PUT /carrinho/{productId} (updateCart).
     *
     * @return void
     */
    public function testUpdateCart()
    {
        $produto = factory(Produto::class)->create();
        
        // Add product to cart first
        $this->get('/carrinho/' . $produto->id);

        $response = $this->put('/carrinho/' . $produto->id, [$produto->id => 2]);

        $response->assertRedirect('/carrinho/' . $produto->id);
        $this->assertEquals(2, session('cart')[$produto->id]['quantidade']);
    }

    /**
     * Test DELETE /carrinho/{productId} (deleteCart).
     *
     * @return void
     */
    public function testDeleteCart()
    {
        $produto = factory(Produto::class)->create();

        // Add product to cart first
        $this->get('/carrinho/' . $produto->id);

        $response = $this->delete('/carrinho/' . $produto->id);

        $response->assertRedirect('/carrinho/' . $produto->id);
        $this->assertArrayNotHasKey($produto->id, session('cart'));
    }
}