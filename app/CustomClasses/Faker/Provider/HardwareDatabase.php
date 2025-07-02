<?php

namespace Faker\Provider;

/**
 * Represents a hardware database that manages information about hardware products, models, and brands.
 *
 * This class provides methods to add and retrieve information about hardware components,
 * including brands, models, and products across various categories like CPUs, GPUs,
 * monitors, memory, drives, keyboards, mice, motherboards, cases, and power supplies.
 *
 * The database is populated with sample data during initialization and supports
 * querying product details, associated models, and brands.
 */
class HardwareDatabase
{
    public array $marcas = [];
    public array $modelos = [];
    public array $produtos = [];

    public function __construct()
    {
        $this->popularDados();
    }

    public function adicionarMarca(int $id, string $nome): void
    {
        if (!isset($this->marcas[$id])) {
            $this->marcas[$id] = $nome;
        }
    }

    public function adicionarModelo(int $id, int $marcaId, string $nome): void
    {
        if (isset($this->marcas[$marcaId]) && !isset($this->modelos[$id])) {
            $this->modelos[$id] = ['marca_id' => $marcaId, 'nome' => $nome];
        }
    }

    public function adicionarProduto(int $id, int $modeloId, string $nome, string $categoria): void
    {
        if (isset($this->modelos[$modeloId]) && !isset($this->produtos[$id])) {
            $this->produtos[$id] = ['modelo_id' => $modeloId, 'nome' => $nome, 'categoria' => $categoria];
        }
    }

    public function getProduto(int $id): ?array
    {
        return $this->produtos[$id] ?? null;
    }

    public function getModelo(int $id): ?array
    {
        return $this->modelos[$id] ?? null;
    }

    public function getMarca(int $id): ?string
    {
        return $this->marcas[$id] ?? null;
    }

    public function getMarcaDoProduto(int $produtoId): ?string
    {
        $produto = $this->getProduto($produtoId);
        if ($produto) {
            $modelo = $this->getModelo($produto['modelo_id']);
            if ($modelo) {
                return $this->getMarca($modelo['marca_id']);
            }
        }
        return null;
    }

    public function getModeloDoProduto(int $produtoId): ?string
    {
        $produto = $this->getProduto($produtoId);
        if ($produto) {
            $modelo = $this->getModelo($produto['modelo_id']);
            if ($modelo) {
                return $modelo['nome'];
            }
        }
        return null;
    }

    private function popularDados(): void
    {
        // Marcas (IDs sequenciais para facilitar)
        $this->adicionarMarca(1, 'Intel');
        $this->adicionarMarca(2, 'Nvidia');
        $this->adicionarMarca(3, 'Samsung');
        $this->adicionarMarca(4, 'Corsair');
        $this->adicionarMarca(5, 'Logitech');
        $this->adicionarMarca(6, 'Asus');
        $this->adicionarMarca(7, 'NZXT');
        $this->adicionarMarca(8, 'Seagate');
        $this->adicionarMarca(9, 'HyperX');
        $this->adicionarMarca(10, 'Cooler Master');
        $this->adicionarMarca(11, 'AMD');

        // Modelos
        // Intel (CPU)
        $this->adicionarModelo(101, 1, 'Core i5');
        $this->adicionarModelo(102, 1, 'Core i7');
        $this->adicionarModelo(103, 1, 'Core i9');
        // AMD (CPU)
        $this->adicionarModelo(2001, 11, 'Ryzen 5 5600X');
        $this->adicionarModelo(2002, 11, 'Ryzen 7 7800X3D');
        $this->adicionarModelo(2003, 11, 'Ryzen 9 9950X3D');
        // Nvidia (GPU)
        $this->adicionarModelo(201, 2, 'GeForce RTX 3060');
        $this->adicionarModelo(202, 2, 'GeForce RTX 3080');
        $this->adicionarModelo(203, 2, 'GeForce RTX 4070');
        // Samsung (Monitor)
        $this->adicionarModelo(301, 3, 'Odyssey G7');
        $this->adicionarModelo(302, 3, 'Curved LED');
        $this->adicionarModelo(303, 3, 'Smart Monitor M8');
        // Corsair (Memórias)
        $this->adicionarModelo(401, 4, 'Vengeance LPX DDR4');
        $this->adicionarModelo(402, 4, 'Dominator Platinum RGB DDR5');
        // Logitech (Keyboard)
        $this->adicionarModelo(501, 5, 'G Pro X Mechanical');
        $this->adicionarModelo(502, 5, 'MX Keys');
        // Asus (Motherboard)
        $this->adicionarModelo(601, 6, 'ROG Strix Z790-E Gaming');
        $this->adicionarModelo(602, 6, 'TUF Gaming B650-Plus');
        // NZXT (Case)
        $this->adicionarModelo(701, 7, 'H510 Flow');
        $this->adicionarModelo(702, 7, 'H7 Elite');
        // Seagate (Drive)
        $this->adicionarModelo(801, 8, 'Barracuda 2TB HDD');
        $this->adicionarModelo(802, 8, 'FireCuda 530 NVMe SSD');
        // HyperX (Mouse)
        $this->adicionarModelo(901, 9, 'Pulsefire Haste');
        $this->adicionarModelo(902, 9, 'Cloud Stinger Core Wireless');
        // Cooler Master (PSU)
        $this->adicionarModelo(1001, 10, 'MWE Gold 750W');
        $this->adicionarModelo(1002, 10, 'V850 SFX Gold');

        // Produtos (IDs sequenciais)
        $produtoId = 1;
        // CPU
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 100 + ($i % 3) + 1; // Cicla entre os modelos Intel
            $this->adicionarProduto($produtoId++, $modeloId, "CPU Intel Gen {$i}", 'CPU');
        }
        // GPU
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 200 + ($i % 3) + 1; // Cicla entre os modelos Nvidia
            $this->adicionarProduto($produtoId++, $modeloId, "GPU Nvidia Série {$i}", 'GPU');
        }
        // Monitor
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 300 + ($i % 3) + 1; // Cicla entre os modelos Samsung
            $this->adicionarProduto($produtoId++, $modeloId, "Monitor Samsung Tela {$i}", 'monitor');
        }
        // Memórias
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 400 + ($i % 2) + 1; // Cicla entre os modelos Corsair
            $this->adicionarProduto($produtoId++, $modeloId, "Memória Corsair {$i}GB", 'memórias');
        }
        // Drives
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 800 + ($i % 2) + 1; // Cicla entre os modelos Seagate
            $tipo = ($modeloId == 801) ? 'HDD' : 'SSD';
            $capacidade = ($modeloId == 801) ? (($i % 5 + 1) * 500) . 'GB' : (($i % 3 + 1) * 1) . 'TB';
            $this->adicionarProduto($produtoId++, $modeloId, "Drive Seagate {$capacidade} {$tipo}", 'drives');
        }
        // Keyboard
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 500 + ($i % 2) + 1; // Cicla entre os modelos Logitech
            $this->adicionarProduto($produtoId++, $modeloId, "Teclado Logitech Modelo {$i}", 'keyboard');
        }
        // Mouse
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 900 + ($i % 2) + 1; // Cicla entre os modelos HyperX
            $this->adicionarProduto($produtoId++, $modeloId, "Mouse HyperX Série {$i}", 'mouse');
        }
        // Placa Mãe
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 600 + ($i % 2) + 1; // Cicla entre os modelos Asus
            $this->adicionarProduto($produtoId++, $modeloId, "Placa Mãe Asus Modelo {$i}", 'placa mãe');
        }
        // Gabinete
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 700 + ($i % 2) + 1; // Cicla entre os modelos NZXT
            $this->adicionarProduto($produtoId++, $modeloId, "Gabinete NZXT Série {$i}", 'gabinete');
        }
        // Fontes
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 1000 + ($i % 2) + 1; // Cicla entre os modelos Cooler Master
            $potencia = (($i % 4 + 1) * 100) + 500;
            $this->adicionarProduto($produtoId++, $modeloId, "Fonte Cooler Master {$potencia}W", 'fontes');
        }
        // CPU AMD
        for ($i = 1; $i <= 20; $i++) {
            $modeloId = 2000 + ($i % 3) + 1; // Cicla entre os modelos Intel
            $this->adicionarProduto($produtoId++, $modeloId, "CPU Intel Gen {$i}", 'CPU');
        }

    }
}

/*
// Exemplo de uso:
$db = new HardwareDatabase();

$produtoId = 5;
$produtoInfo = $db->getProduto($produtoId);
if ($produtoInfo) {
    $modeloNome = $db->getModeloDoProduto($produtoId);
    $marcaNome = $db->getMarcaDoProduto($produtoId);
    echo "Produto ID: {$produtoId}\n";
    echo "Nome: {$produtoInfo['nome']}\n";
    echo "Categoria: {$produtoInfo['categoria']}\n";
    echo "Modelo: {$modeloNome}\n";
    echo "Marca: {$marcaNome}\n";
} else {
    echo "Produto com ID {$produtoId} não encontrado.\n";
}

$produtoId = 35;
$produtoInfo = $db->getProduto($produtoId);
if ($produtoInfo) {
    $modeloNome = $db->getModeloDoProduto($produtoId);
    $marcaNome = $db->getMarcaDoProduto($produtoId);
    echo "\nProduto ID: {$produtoId}\n";
    echo "Nome: {$produtoInfo['nome']}\n";
    echo "Categoria: {$produtoInfo['categoria']}\n";
    echo "Modelo: {$modeloNome}\n";
    echo "Marca: {$marcaNome}\n";
} else {
    echo "Produto com ID {$produtoId} não encontrado.\n";
}
 */
