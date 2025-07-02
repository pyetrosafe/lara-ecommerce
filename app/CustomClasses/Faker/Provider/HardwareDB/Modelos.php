<?php

namespace Faker\Provider\HardwareDB;

class Modelos
{
    public array $modelos = [];

    public function __construct()
    {
        // TODO: Implementar checagem de categorias no ProdutosParceiros
        $this->modelos = [
            101 => ['marca_id' => 1, 'nome' => 'Core i5', 'categorias' => ['CPU']],
            102 => ['marca_id' => 1, 'nome' => 'Core i7', 'categorias' => ['CPU']],
            103 => ['marca_id' => 1, 'nome' => 'Core i9', 'categorias' => ['CPU']],
            201 => ['marca_id' => 2, 'nome' => 'Ryzen 5', 'categorias' => ['CPU']],
            202 => ['marca_id' => 2, 'nome' => 'Ryzen 7', 'categorias' => ['CPU']],
            203 => ['marca_id' => 2, 'nome' => 'Ryzen 9', 'categorias' => ['CPU']],
            301 => ['marca_id' => 3, 'nome' => 'GeForce GTX', 'categorias' => ['GPU']],
            302 => ['marca_id' => 3, 'nome' => 'GeForce RTX', 'categorias' => ['GPU']],
            303 => ['marca_id' => 2, 'nome' => 'Radeon RX', 'categorias' => ['GPU']],
            304 => ['marca_id' => 1, 'nome' => 'ARC', 'categorias' => ['GPU']],
            401 => ['marca_id' => 4, 'nome' => 'Shadow 3X OC', 'categorias' => ['GPU']],
            402 => ['marca_id' => 4, 'nome' => 'Gaming Trio OC', 'categorias' => ['GPU']],
            403 => ['marca_id' => 4, 'nome' => 'Ventus 3X OC', 'categorias' => ['GPU']],
            404 => ['marca_id' => 4, 'nome' => 'Vanguard SOC Launch Edition', 'categorias' => ['GPU']],
            405 => ['marca_id' => 4, 'nome' => 'Suprim Liquid SOC', 'categorias' => ['GPU']],
            501 => ['marca_id' => 5, 'nome' => 'ROG Strix', 'categorias' => ['GPU', 'Placa Mãe']],
            502 => ['marca_id' => 5, 'nome' => 'TUF Gaming', 'categorias' => ['GPU', 'Placa Mãe']],
            503 => ['marca_id' => 5, 'nome' => 'DUAL OC', 'categorias' => ['GPU']],
            601 => ['marca_id' => 6, 'nome' => 'Vengeance LPX', 'categorias' => ['Memórias']],
            602 => ['marca_id' => 6, 'nome' => 'Dominator Platinum RGB', 'categorias' => ['Memórias']],
            801 => ['marca_id' => 8, 'nome' => 'Odyssey G7', 'categorias' => ['Monitor']],
            802 => ['marca_id' => 8, 'nome' => 'Curved LED', 'categorias' => ['Monitor']],
            901 => ['marca_id' => 7, 'nome' => 'G Pro X Mechanical', 'categorias' => ['Teclado']],
            902 => ['marca_id' => 7, 'nome' => 'MX Keys', 'categorias' => ['Teclado']],
            1001 => ['marca_id' => 7, 'nome' => 'G Pro Wireless', 'categorias' => ['Mouse']],
            1002 => ['marca_id' => 7, 'nome' => 'MX Master 3S', 'categorias' => ['Mouse']],
            1101 => ['marca_id' => 11, 'nome' => 'H510 Flow', 'categorias' => ['Gabinete']],
            1102 => ['marca_id' => 11, 'nome' => 'H7 Elite', 'categorias' => ['Gabinete']],
            1201 => ['marca_id' => 6, 'nome' => 'RMx Series', 'categorias' => ['Fonte']],
            1202 => ['marca_id' => 6, 'nome' => 'HX Series', 'categorias' => ['Fonte']],
            1301 => ['marca_id' => 9, 'nome' => 'Barracuda HDD', 'categorias' => ['Drive']],
            1302 => ['marca_id' => 9, 'nome' => 'FireCuda SSD', 'categorias' => ['Drive']],
            1401 => ['marca_id' => 10, 'nome' => 'Fury', 'categorias' => ['Memórias']],
            1402 => ['marca_id' => 10, 'nome' => 'Predator', 'categorias' => ['Memórias']],
            1501 => ['marca_id' => 4, 'nome' => 'MPG', 'categorias' => ['Placa Mãe']],
            1502 => ['marca_id' => 4, 'nome' => 'MAG', 'categorias' => ['Placa Mãe']],
            1503 => ['marca_id' => 4, 'nome' => 'Tomahawk', 'categorias' => ['Placa Mãe']],
            1601 => ['marca_id' => 5, 'nome' => 'ROG Swift PG', 'categorias' => ['Monitor']],
            1602 => ['marca_id' => 5, 'nome' => 'TUF Gaming VG', 'categorias' => ['Monitor']],
            1701 => ['marca_id' => 10, 'nome' => 'Alloy Origins', 'categorias' => ['Teclado']],
            1702 => ['marca_id' => 10, 'nome' => 'Alloy FPS Pro', 'categorias' => ['Teclado']],
            1801 => ['marca_id' => 10, 'nome' => 'Pulsefire Haste', 'categorias' => ['Mouse']],
            1802 => ['marca_id' => 10, 'nome' => 'Pulsefire Surge', 'categorias' => ['Mouse']],
            1901 => ['marca_id' => 12, 'nome' => 'MasterBox', 'categorias' => ['Gabinete']],
            1902 => ['marca_id' => 12, 'nome' => 'MasterCase', 'categorias' => ['Gabinete']],
            2001 => ['marca_id' => 12, 'nome' => 'MWE Gold', 'categorias' => ['Fonte']],
            2002 => ['marca_id' => 12, 'nome' => 'V Series', 'categorias' => ['Fonte']],
            2101 => ['marca_id' => 8, 'nome' => '980 Pro NVMe SSD', 'categorias' => ['Drive']],
            2102 => ['marca_id' => 8, 'nome' => '870 EVO SATA SSD', 'categorias' => ['Drive']],
        ];
    }

    public function adicionarModelo(int $id, int $marcaId, string $nome): void
    {
        if (!isset($this->modelos[$id])) {
            $this->modelos[$id] = ['marca_id' => $marcaId, 'nome' => $nome];
        }
    }

    public function getModelo(int $id): ?array
    {
        return $this->modelos[$id] ?? null;
    }

    public function listarModelos(): array
    {
        return $this->modelos;
    }

    public function getModeloPorMarcaId(int $marcaId): ?array
    {
        $resultado = [];
        foreach ($this->modelos as $id => $modelo) {
            if ($modelo['marca_id'] === $marcaId) {
                $resultado[$id] = $modelo;
            }
        }
        return !empty($resultado) ? $resultado : null;
    }

    public function listarModelosPorMarcaCategoria(array $marcaIds, $categoriaId): array
    {
        $resultado = [];
        foreach ($this->modelos as $id => $modelo) {
            if (in_array($modelo['marca_id'], $marcaIds) && in_array($categoriaId, $modelo['categorias'])) {
                $resultado[$id] = $modelo;
            }
        }
        return !empty($resultado) ? $resultado : [];
    }
}
