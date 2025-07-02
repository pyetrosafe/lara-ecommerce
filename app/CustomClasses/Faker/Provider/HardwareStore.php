<?php

namespace Faker\Provider;

$CATEGORIAS = array('CPU', 'GPU', 'Memórias', 'Placa Mãe', 'Monitor', 'Drive', 'Keyboard', 'Mouse', 'Gabinete', 'Fonte');

class HardwareStore {
    private $categorias;
    private $marcas;
    private $modelos;
    private $produtos;
    private $produtosParceiros;

    public function __construct() {
        $this->categorias = array();
        $this->marcas = array();
        $this->modelos = array();
        $this->produtos = array();
        $this->produtosParceiros = array();
    }

    public function addCategoria($nome) {
        if (!in_array($nome, $this->categorias)) {
            $this->categorias[$nome] = count($this->categorias) + 1;
        }
    }

    public function getCategorias() {
        return $this->categorias;
    }

    public function addMarca($nome) {
        if (!in_array($nome, $this->marcas)) {
            $this->marcas[$nome] = count($this->marcas) + 1;
        }
    }

    public function getMarcas() {
        return $this->marcas;
    }

    public function addModelo($marca_id, $nome) {
        if (!isset($this->modelos[$marca_id])) {
            throw new \Exception("Marca não encontrada");
        }
        $this->modelos[$marca_id][$nome] = count($this->modelos[$marca_id]) + 1;
    }

    public function getModelos() {
        return $this->modelos;
    }

    public function addProduto($modelo_id, $nome, $categoria) {
        if (!isset($this->modelos[$modelo_id])) {
            throw new \Exception("Modelo não encontrado");
        }
        $produto = array(
            'modelo_id' => $modelo_id,
            'nome' => $nome,
            'categoria' => $categoria
        );
        $this->produtos[] = $produto;
    }

    public function getProdutos() {
        return $this->produtos;
    }

    public function addProdutoParceiro($produto_id, $modelo_id) {
        if (!isset($this->produtos[$produto_id])) {
            throw new \Exception("Produto não encontrado");
        }
        if (!isset($this->modelos[$modelo_id])) {
            throw new \Exception("Modelo não encontrado");
        }
        $this->produtosParceiros[] = array('produto_id' => $produto_id, 'modelo_id' => $modelo_id);
    }

    public function getProdutosParceiros() {
        return $this->produtosParceiros;
    }
}
/*
// Exemplo de uso:
$hardwareStore = new HardwareStore();

foreach ($CATEGORIAS as $categoria) {
    $hardwareStore->addCategoria($categoria);
}

$marcas = array(
    1 => 'Intel', 2 => 'AMD', 3 => 'Nvidia', 4 => 'MSI', 5 => 'Asus'
);
foreach ($marcas as $id => $nome) {
    $hardwareStore->addMarca($nome);
}

$modelos = array(
    101 => array('marca_id' => 1, 'nome' => 'Core i5'),
    102 => array('marca_id' => 1, 'nome' => 'Core i7'),
    201 => array('marca_id' => 2, 'nome' => 'Ryzen 5'),
    202 => array('marca_id' => 2, 'nome' => 'Ryzen 7'),
    301 => array('marca_id' => 3, 'nome' => 'Geforce GTX'),
    302 => array('marca_id' => 3, 'nome' => 'Geforce RTX')
);
foreach ($modelos as $modelo) {
    $hardwareStore->addModelo($modelo['marca_id'], $modelo['nome']);
}

$produtos = array(
    1 => array('modelo_id' => 101, 'nome' => '9600', 'categoria' => 1),
    2 => array('modelo_id' => 101, 'nome' => '10600', 'categoria' => 1),
    // Adicione mais produtos conforme necessário...
);
foreach ($produtos as $produto) {
    $hardwareStore->addProduto($produto['modelo_id'], $produto['nome'], $produto['categoria']);
}

$produtosParceiros = array(
    array('produto_id' => 23, 'modelo_id' => 404),
    array('produto_id' => 23, 'modelo_id' => 405),
    // Adicione mais produtos parceiros conforme necessário...
);
foreach ($produtosParceiros as $parceiro) {
    $hardwareStore->addProdutoParceiro($parceiro['produto_id'], $parceiro['modelo_id']);
}

// Exemplo de como acessar os dados:
echo "Categorias:\n";
print_r($hardwareStore->getCategorias());

echo "\nMarcas:\n";
print_r($hardwareStore->getMarcas());

echo "\nModelos:\n";
print_r($hardwareStore->getModelos());

echo "\nProdutos:\n";
print_r($hardwareStore->getProdutos());

echo "\nProdutos Parceiros:\n";
print_r($hardwareStore->getProdutosParceiros());
 */
