<?php

namespace Faker\Provider\HardwareDB;

class Categorias
{
    public array $categorias = [];

    public function __construct()
    {
        $this->categorias = [
            1 => 'CPU',
            2 => 'GPU',
            3 => 'Memórias',
            4 => 'Placa Mãe',
            5 => 'Monitor',
            6 => 'Teclado',
            7 => 'Mouse',
            8 => 'Gabinete',
            9 => 'Fonte',
            10 => 'Drive',
        ];
    }

    public function adicionarCategoria(int $id, string $nome): void
    {
        if (!isset($this->categorias[$id])) {
            $this->categorias[$id] = $nome;
        }
    }

    public function getCategoriaNome(int $id): ?string
    {
        return $this->categorias[$id] ?? null;
    }

    public function getCategoriaId(string $nome): ?int
    {
        $id = array_search($nome, $this->categorias);
        return $id !== false ? $id : null;
    }

    public function listarCategorias(): array
    {
        return $this->categorias;
    }
}
