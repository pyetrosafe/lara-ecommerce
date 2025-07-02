<?php

namespace Faker\Provider\HardwareDB;

class Marcas
{
    public array $marcas = [];

    public function __construct()
    {
        $this->marcas = [
            1 => 'Intel',
            2 => 'AMD',
            3 => 'Nvidia',
            4 => 'MSI',
            5 => 'Asus',
            6 => 'Corsair',
            7 => 'Logitech',
            8 => 'Samsung',
            9 => 'Seagate',
            10 => 'HyperX',
            11 => 'NZXT',
            12 => 'Cooler Master',
        ];
    }

    public function adicionarMarca(int $id, string $nome): void
    {
        if (!isset($this->marcas[$id])) {
            $this->marcas[$id] = $nome;
        }
    }

    public function getMarcaNome(int $id): ?string
    {
        return $this->marcas[$id] ?? null;
    }

    public function getMarcaId(string $nome): ?int
    {
        $id = array_search($nome, $this->marcas);
        return $id !== false ? $id : null;
    }

    public function getMarcaPorNomes(...$nomes): ?array
    {
        $resultado = [];
        foreach ($nomes as $nome) {
            $id = $this->getMarcaId($nome);
            if ($id !== null) {
                $resultado[$id] = $this->marcas[$id];
            }
        }
        return !empty($resultado) ? $resultado : null;
    }

    public function listarMarcas(): array
    {
        return $this->marcas;
    }
}
