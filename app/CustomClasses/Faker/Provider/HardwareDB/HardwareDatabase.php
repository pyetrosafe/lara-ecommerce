<?php

namespace Faker\Provider\HardwareDB;

use Faker\Provider\HardwareDB\Categorias;
use Faker\Provider\HardwareDB\Marcas;
use Faker\Provider\HardwareDB\Modelos;
use Faker\Provider\HardwareDB\Produtos;
use Faker\Provider\HardwareDB\ProdutosParceiros;
use Illuminate\Container\Container;

class HardwareDatabase
{
    private Categorias $categorias;
    private Marcas $marcas;
    private Modelos $modelos;
    private Produtos $produtos;
    private ProdutosParceiros $produtosParceiros;

    private $produtosTituloVenda = [];

    /**
     * Initializes the HardwareDatabase instance by creating instances of various hardware-related classes
     * and populating them with initial data.
     *
     * This constructor sets up the following components:
     * - Categorias (Categories)
     * - Marcas (Brands)
     * - Modelos (Models)
     * - Produtos (Products)
     * - ProdutosParceiros (Partner Products)
     *
     * After instantiation, it calls methods to populate initial data for brands and partner products.
     */
    public function __construct()
    {
        $this->categorias = new Categorias();
        $this->marcas = new Marcas();
        $this->modelos = new Modelos();
        $this->produtos = new Produtos();
        $this->popularDados();
        // $this->produtosParceiros = new ProdutosParceiros();
        $this->produtosParceiros = app(ProdutosParceiros::class);
        // $this->popularProdutosParceiros();
    }

    /* public function __construct(Categorias $categorias, Marcas $marcas, Modelos $modelos, Produtos $produtos, ProdutosParceiros $produtosParceiros)
    {
        $this->categorias = $categorias;
        $this->marcas = $marcas;
        $this->modelos = $modelos;
        $this->produtos = $produtos;
        $this->produtosParceiros = $produtosParceiros;
    } */

    /**
         * Populates initial data for hardware database brands and models.
         *
         * This method adds additional brands like NZXT and Cooler Master.
         * It assumes that initial models have already been defined in the Modelos class
         * and that products have been populated in the Produtos class.
         */
    private function popularDados(): void
    {
        // Adiciona mais marcas se necessário para cobrir todas as categorias
        $this->marcas->adicionarMarca(11, 'NZXT');
        $this->marcas->adicionarMarca(12, 'Cooler Master');

        // Adiciona mais modelos se necessário
        // (Os modelos iniciais já foram definidos na classe Modelos)

        // Os produtos já foram populados na classe Produtos
    }

    /**
         * Populates partner products for various GPU models across different brands.
         *
         * This method adds partner product associations for Nvidia GPUs, specifically:
         * - Mapping GPU models to partner brands like MSI and Asus
         * - Associating different GPU variants with specific partner model editions
         *
         * Partner product mappings include various GPU series such as:
         * - GTX 1080 Ti
         * - RTX 2060 Super
         * - RTX 3060, 3070, 3080
         * - RTX 4060, 4070
         *
         * Partner brands include MSI (with editions like Gaming Trio OC, Ventus 3X OC)
         * and Asus (with editions like TUF Gaming, ROG Strix, DUAL OC).
         */
    private function popularProdutosParceiros(): void
    {
        // Produtos de GPU (categoria 2) como parceiros
        // $this->produtosParceiros->adicionarProdutoParceiro(23, 404); // GTX 1080 Ti (Nvidia) vendido por MSI (Vanguard SOC Launch Edition)
        // $this->produtosParceiros->adicionarProdutoParceiro(23, 405); // GTX 1080 Ti (Nvidia) vendido por MSI (Suprim Liquid SOC)
        // $this->produtosParceiros->adicionarProdutoParceiro(24, 402); // RTX 2060 Super (Nvidia) vendido por MSI (Gaming Trio OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(25, 402); // RTX 3060 (Nvidia) vendido por MSI (Gaming Trio OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(25, 403); // RTX 3060 (Nvidia) vendido por MSI (Ventus 3X OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(26, 404); // RTX 3070 (Nvidia) vendido por MSI (Vanguard SOC Launch Edition)
        // $this->produtosParceiros->adicionarProdutoParceiro(27, 404); // RTX 3080 (Nvidia) vendido por MSI (Vanguard SOC Launch Edition)
        // $this->produtosParceiros->adicionarProdutoParceiro(28, 402); // RTX 4060 (Nvidia) vendido por MSI (Gaming Trio OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(28, 403); // RTX 4060 (Nvidia) vendido por MSI (Ventus 3X OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(29, 404); // RTX 4070 (Nvidia) vendido por MSI (Vanguard SOC Launch Edition)
        // $this->produtosParceiros->adicionarProdutoParceiro(29, 405); // RTX 4070 (Nvidia) vendido por MSI (Suprim Liquid SOC)

        // $this->produtosParceiros->adicionarProdutoParceiro(25, 502); // RTX 3060 (Nvidia) vendido por Asus (TUF Gaming)
        // $this->produtosParceiros->adicionarProdutoParceiro(25, 503); // RTX 3060 (Nvidia) vendido por Asus (DUAL OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(26, 501); // RTX 3070 (Nvidia) vendido por Asus (ROG Strix)
        // $this->produtosParceiros->adicionarProdutoParceiro(26, 502); // RTX 3070 (Nvidia) vendido por Asus (TUF Gaming)
        // $this->produtosParceiros->adicionarProdutoParceiro(27, 501); // RTX 3080 (Nvidia) vendido por Asus (ROG Strix)
        // $this->produtosParceiros->adicionarProdutoParceiro(28, 502); // RTX 4060 (Nvidia) vendido por Asus (TUF Gaming)
        // $this->produtosParceiros->adicionarProdutoParceiro(28, 503); // RTX 4060 (Nvidia) vendido por Asus (DUAL OC)
        // $this->produtosParceiros->adicionarProdutoParceiro(29, 503); // RTX 4070 (Nvidia) vendido por Asus (DUAL OC)
    }

    /**
         * Retrieves the name of a category by its unique identifier.
         *
         * @param int $id The unique identifier of the category
         * @return string|null The name of the category, or null if not found
         */
    public function getCategoriaNome(int $id): ?string
    {
        return $this->categorias->getCategoriaNome($id);
    }

    /**
     * Retrieves the name of a brand by its unique identifier.
     * @param int $id The unique identifier of the brand
     * @return string|null The name of the brand, or null if not found
     */
    public function listarCategorias(): array
    {
        return $this->categorias->listarCategorias();
    }

    /**
     * Retrieves the name of a brand by its unique identifier.
     *
     * @param int $id The unique identifier of the brand
     * @return string|null The name of the brand, or null if not found
     */
    public function getMarcaNome(int $id): ?string
    {
        return $this->marcas->getMarcaNome($id);
    }

    /**
     * Retrieves the name of a brand by its unique identifier.
     *
     * @param int $id The unique identifier of the brand
     * @return string|null The name of the brand, or null if not found
     */
    public function listarMarcas(): array
    {
        return $this->marcas->listarMarcas();
    }

    /**
     * Retrieves a model by its unique identifier.
     *
     * @param int $id The unique identifier of the model to retrieve
     * @return array|null The model details as an associative array, or null if not found
     */
    public function getModelo(int $id): ?array
    {
        return $this->modelos->getModelo($id);
    }

    /**
     * Retrieves a model by its unique identifier.
     *
     * @param int $id The unique identifier of the model to retrieve
     * @return array|null The model details as an associative array, or null if not found
     */
    public function listarModelos(): array
    {
        return $this->modelos->listarModelos();
    }

    /**
     * Retrieves a product by its unique identifier.
     *
     * @param int $id The unique identifier of the product to retrieve
     * @return array|null The product details as an associative array, or null if not found
     */
    public function getProduto(int $id): ?array
    {
        $produtoParceiro = $this->produtosParceiros->getProdutoParceiro($id);
        if ($produtoParceiro !== null) {
            $modeloParceiro = $this->modelos->getModelo($produtoParceiro['modelo_id']);
            $produtoOriginal = $this->produtos->getProduto($id);
            $modeloOriginal = $this->modelos->getModelo($produtoOriginal['modelo_id']);
            if ($modeloParceiro && $produtoOriginal) {
                $marcaParceiro = $this->marcas->getMarcaNome($modeloParceiro['marca_id']);
                $marcaNome = $this->marcas->getMarcaNome($modeloOriginal['marca_id']);
                return [
                    'id' => $id,
                    'modelo_id' => $produtoParceiro['modelo_id'],
                    'nome' => $modeloOriginal['nome'] . ' ' . $produtoOriginal['nome'] . ' ' . $modeloParceiro['nome'],
                    'categoria' => $this->categorias->getCategoriaNome($produtoOriginal['categoria']),
                    'marca' => $marcaNome,
                    'marca_parceiro' => $marcaParceiro
                ];
            }
        }
        // Se não for um produto parceiro, retorna o produto original
        else {
            $produto = $this->produtos->getProduto($id);
            $modeloId = $produto['modelo_id'];
            $modelo = $this->modelos->getModelo($modeloId);
            if ($modelo) {
                $marcaNome = $this->marcas->getMarcaNome($modelo['marca_id']);
                return [
                    'id' => $id,
                    'modelo_id' => $modeloId,
                    'nome' => $modelo['nome'] . ' ' . $produto['nome'],
                    'categoria' => $this->categorias->getCategoriaNome($produto['categoria']),
                    'marca' => $marcaNome
                ];
            }
        }
        return $this->produtos->getProduto($id);
    }

    /**
     * Retrieves all products.
     *
     * @return array|null The product details as an associative array, or null if not found
     */
    public function getProdutos(): ?array
    {
        $produtos = [];
        foreach ($this->produtos->listarProdutos() as $k => $v) {
            $produtos[] = $this->getProduto($k);
        }
        return $produtos;
    }

    /**
     * Retrieves all products with their titles for sale.
     *
     * @return array|null The product details as an associative array, or null if not found
     */
    public function getProdutosTituloVenda(): ?array
    {
        $this->produtosTituloVenda = [];
        foreach ($this->produtos->listarProdutos() as $k => $v) {
            $produto = $this->getProduto($k);
            $produto = $produto['categoria'] . (isset($produto['marca_parceiro']) ? ' ' . $produto['marca_parceiro'] : '' ) . ' ' . $produto['marca'] . ' ' . $produto['nome'];
            $this->produtosTituloVenda[] = $produto;
        }
        return $this->produtosTituloVenda;
    }

    public function randomProdutoNome(): ?string
    {
        $produtos = !empty($this->produtosTituloVenda) ? $this->produtosTituloVenda : $this->getProdutosTituloVenda();
        return $produtos[array_rand($produtos)];
    }

    public function listarProdutos(): array
    {
        return $this->produtos->listarProdutos();
    }

    public function adicionarCategoria(int $id, string $nome): void
    {
        $this->categorias->adicionarCategoria($id, $nome);
    }

    public function adicionarMarca(int $id, string $nome): void
    {
        $this->marcas->adicionarMarca($id, $nome);
    }

    public function adicionarModelo(int $id, int $marcaId, string $nome): void
    {
        $this->modelos->adicionarModelo($id, $marcaId, $nome);
    }

    public function adicionarProduto(int $id, int $modeloId, string $nome, int $categoriaId): void
    {
        $this->produtos->adicionarProduto($id, $modeloId, $nome, $categoriaId);
    }

    public function adicionarProdutoParceiro(int $produtoId, int $modeloId): void
    {
        $this->produtosParceiros->adicionarProdutoParceiro($produtoId, $modeloId);
    }

    public function listarProdutosParceiros(): array
    {
        return $this->produtosParceiros->listarProdutosParceiros();
    }
}
