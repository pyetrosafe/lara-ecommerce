<?php

namespace Faker\Provider\HardwareDB;

use Faker\Provider\HardwareDB\Produtos;
use Illuminate\Database\Eloquent\Model;

class ProdutosParceiros
{
    public array $produtosParceiros = [];
    private Produtos $produtos;
    private Categorias $categorias;
    private Marcas $marcas;
    private Modelos $modelos;

    public function __construct(Produtos $produtos, Categorias $categorias, Marcas $marcas, Modelos $modelos)
    {
        $this->produtos = $produtos;
        $this->categorias = $categorias;
        $this->marcas = $marcas;
        $this->modelos = $modelos;
        $this->inicializarProdutosParceiros();
    }

    // Inicializa a lista de produtos parceiros com dados fictícios
    public function inicializarProdutosParceiros(): void
    {
        $categoria = $this->categorias->getCategoriaId('GPU');
        $produtos = $this->produtos->listarProdutosPorCategoria($categoria);
        $marcas = $this->marcas->getMarcaPorNomes('Asus', 'MSI');
        $modelos = $this->modelos->listarModelosPorMarcaCategoria(array_keys($marcas), 'GPU');

        foreach ($produtos as $key => $produto) {
            $this->produtosParceiros[] = [
                'produto_id' => $key,
                'modelo_id' => array_rand($modelos),
            ];
        }
    }

    public function adicionarProdutoParceiro(int $produtoId, int $modeloId): void
    {
        $this->produtosParceiros[] = ['produto_id' => $produtoId, 'modelo_id' => $modeloId];
    }

    public function listarProdutosParceiros(): array
    {
        return $this->produtosParceiros;
    }

    public function getModeloId(int $produtoId): ?int
    {
        foreach ($this->produtosParceiros as $parceiro) {
            if ($parceiro['produto_id'] === $produtoId) {
                return $parceiro['modelo_id'];
            }
        }
        return null;
    }

    public function getProdutoParceiro(int $produtoId): ?array
    {
        foreach ($this->produtosParceiros as $parceiro) {
            if ($parceiro['produto_id'] === $produtoId) {
                return $parceiro;
            }
        }
        return null;
    }
}
