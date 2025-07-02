<?php

namespace Faker\Provider\HardwareDB;

class Produtos
{
    public array $produtos = [];

    public function __construct()
    {
        $this->inicializarProdutos();
    }

    private function inicializarProdutos(): void
    {
        $produtoId = 1;

        // CPU (Categoria 1)
        $cpus = [
            101 => [
                '9600',
                '10600',
                '11600F',
                '12400F',
                '12600K',
                '13600K'
            ],
            102 => [
                '11700',
                '11700F',
                '11700K',
                '13700',
                '9700K',
                '10700K',
                '12700K',
                '14700K'
            ],
            103 => [
                '13900K',
                '14900K'
            ],
            201 => [
                '3400G',
                '3500X',
                '3600',
                '3600X',
                '5600G',
                '7600X',
                '9600X'
            ],
            202 => [
                '5700X',
                '5800X',
                '5800X3D',
                '7700X',
                '7800X3D',
                '9800X3D'
            ],
            203 => [
                '5900X',
                '5950X',
                '5950X3D',
                '7900X',
                '7950X',
                '7950X3D',
                '9900X',
                '9950X',
                '9950X3D'
            ]
        ];
        foreach ($cpus as $modeloId => $cpu_models) {
            foreach ($cpu_models as $cpu) {
                $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $cpu, 'categoria' => 1];
            }
        }

        // GPU (Categoria 2)
        $gpus = [
            301 => [
                '1650',
                '1660 Super',
                '1660 Ti'
            ],
            302 => [
                '2060',
                '3050',
                '3060',
                '3070',
                '3080',
                '4060',
                '4070',
                '4080',
            ],
            303 => [
                '6600',
                '6700 XT',
                '6800',
                '6900 XT',
                '7600',
                '7700 XT',
                '7800 XT',
                '7900 XT',
            ],
            304 => [
                'A750',
                'A770'
            ]
        ];
        foreach ($gpus as $modeloId => $gpu_models) {
            foreach ($gpu_models as $gpu) {
                $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $gpu, 'categoria' => 2];
            }
        }

        // Memórias (Categoria 3)
        $memorias = [
            '8GB DDR4 3200MHz',
            '16GB DDR4 3200MHz',
            '16GB DDR4 3600MHz',
            '32GB DDR4 3200MHz',
            '32GB DDR4 3600MHz',
            '64GB DDR4 3200MHz',
            '16GB DDR5 4800MHz',
            '32GB DDR5 5200MHz',
            '32GB DDR5 6000MHz',
            '64GB DDR5 5600MHz',
            '8GB DDR3 1600MHz',
            '16GB DDR3 1600MHz',
            '4GB DDR4 2400MHz',
            '8GB DDR4 2666MHz',
            '16GB DDR5 5600MHz',
            '32GB DDR5 6400MHz',
            '8GB DDR4 3000MHz',
            '16GB DDR4 3000MHz',
            '32GB DDR4 2666MHz',
            '64GB DDR4 3600MHz'
        ];
        foreach ($memorias as $memoria) {
            $modeloId = (strpos($memoria, 'DDR5') !== false) ? 602 : 601;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $memoria, 'categoria' => 3];
        }

        // Placa Mãe (Categoria 4)
        $placasMae = [
            'B450M',
            'B550M',
            'X570',
            'B650',
            'Z690',
            'Z790',
            'H610M',
            'H670',
            'B760',
            'H770',
            'A520M',
            'A620',
            'H310M',
            'H410M',
            'B360',
            'Z390',
            'X299'
        ];
        foreach ($placasMae as $placaMae) {
            $modeloId = (strpos($placaMae, 'Z') !== false) ? 501 :
                            ((strpos($placaMae, 'X') !== false) ? 502 :
                                    ((strpos($placaMae, 'B') !== false) ? 1501 :
                                            ((strpos($placaMae, 'H') !== false) ? 1502 : 1503)));
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $placaMae, 'categoria' => 4];
        }

        // Monitor (Categoria 5)
        $monitores = ['24 Polegadas FHD 60Hz',
            '27 Polegadas FHD 144Hz',
            '27 Polegadas QHD 144Hz',
            '32 Polegadas QHD 165Hz Curvo',
            '34 Polegadas UWQHD 144Hz Curvo',
            '24 Polegadas FHD 75Hz IPS',
            '27 Polegadas QHD 75Hz IPS',
            '32 Polegadas 4K 60Hz',
            '28 Polegadas 4K 144Hz',
            '34 Polegadas UWQHD 100Hz',
            '21.5 Polegadas FHD 60Hz',
            '23.8 Polegadas FHD 75Hz',
            '27 Polegadas FHD 240Hz',
            '32 Polegadas QHD 240Hz Curvo',
            '29 Polegadas UWFHD 75Hz',
            '25 Polegadas FHD 144Hz',
            '31.5 Polegadas QHD 144Hz',
            '27 Polegadas 4K 60Hz',
            '38 Polegadas UWQHD+ 144Hz Curvo',
            '24.5 Polegadas FHD 165Hz'
        ];
        foreach ($monitores as $monitor) {
            $modeloId = (strpos($monitor, 'Odyssey') !== false) ? 801 : 802;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $monitor, 'categoria' => 5];
        }

        // Teclado (Categoria 6)
        $teclados = ['Mecânico RGB Switch Azul',
            'Mecânico RGB Switch Vermelho',
            'Mecânico TKL Switch Marrom',
            'Membrana Retroiluminado',
            'Sem Fio Bluetooth',
            'Mecânico RGB Switch Preto',
            'Membrana Slim',
            'Ergonômico Dividido',
            'Mini 60% Mecânico',
            'Com Fio USB',
            'Mecânico Switch Verde',
            'Membrana Anti-Ghosting',
            'Sem Fio 2.4GHz',
            'Híbrido Mecânico-Membrana',
            'Numérico Sem Fio',
            'Para Jogos com Macros',
            'Compacto Sem Fio',
            'Com Descanso de Pulso',
            'Resistente à Água',
            'Com Teclas Programáveis'
        ];
        foreach ($teclados as $teclado) {
            $modeloId = (strpos($teclado, 'Pro X') !== false) ? 901 : 902;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $teclado, 'categoria' => 6];
        }

        // Mouse (Categoria 7)
        $mouses = ['Sem Fio Ergonômico',
            'Sem Fio para Jogos',
            'Com Fio para Jogos RGB',
            'Óptico Básico',
            'Laser de Alta Precisão',
            'Vertical Ergonômico',
            'Com Botões Laterais',
            'Leve para Jogos',
            'Bluetooth Compacto',
            'Com Fio Ambidestro',
            'Sem Fio com Bateria de Longa Duração',
            'Para Jogos MMO',
            'Com Ajuste de DPI',
            'Com Scroll Horizontal',
            'Para Design Gráfico',
            'Silencioso Sem Fio',
            'Com Sensor Infravermelho',
            'Com Base de Carregamento Sem Fio',
            'Pequeno e Portátil',
            'Com Iluminação Personalizável'
        ];
        foreach ($mouses as $mouse) {
            $modeloId = (strpos($mouse, 'Pro Wireless') !== false) ? 1001 : 1002;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $mouse, 'categoria' => 7];
        }

        // Gabinete (Categoria 8)
        $gabinetes = ['Mid-Tower com Janela Lateral',
            'Full-Tower para Water Cooling',
            'Mini-ITX Compacto',
            'Micro-ATX com Bom Fluxo de Ar',
            'Com Iluminação RGB Frontal',
            'Discreto sem Janela',
            'Com Painel Frontal em Malha',
            'Para Servidor 4U Rackmount',
            'Estilo Retro',
            'Open Frame',
            'Mid-Tower Branco',
            'Full-Tower Preto',
            'Mini-ITX com Fonte Integrada',
            'Micro-ATX com Painel de Vidro Temperado',
            'Com Controladora RGB',
            'Sem Fonte',
            'Com Filtros de Poeira',
            'Para Jogos com Suporte Vertical de GPU',
            'Silencioso com Isolamento Acústico',
            'Com USB Tipo-C Frontal'
        ];
        foreach ($gabinetes as $gabinete) {
            $modeloId = (strpos($gabinete, 'H510') !== false) ? 1101 : 1102;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $gabinete, 'categoria' => 8];
        }

        // Fonte (Categoria 9)
        $fontes = ['500W 80+ Bronze',
            '650W 80+ Gold',
            '750W 80+ Platinum',
            '850W 80+ Titanium',
            '1000W 80+ Gold Modular',
            '450W 80+ White',
            '550W 80+ Bronze Semi-Modular',
            '700W 80+ Gold Não Modular',
            '900W 80+ Platinum Modular',
            '1200W 80+ Titanium',
            '300W Sem Certificação',
            '400W 80+',
            '600W 80+ Bronze Modular',
            '800W 80+ Gold Semi-Modular',
            '1100W 80+ Platinum',
            '1300W 80+ Titanium Modular',
            '450W 80+ White PFC Ativo',
            '650W 80+ Gold PFC Ativo',
            '850W 80+ Platinum PFC Ativo',
            '1000W 80+ Titanium PFC Ativo'
        ];
        foreach ($fontes as $fonte) {
            $modeloId = (strpos($fonte, 'RMx') !== false) ? 1201 : 1202;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $fonte, 'categoria' => 9];
        }

        // Drive (Categoria 10)
        $drives = ['SSD 250GB SATA',
            'SSD 500GB SATA',
            'SSD 1TB SATA',
            'SSD 2TB SATA',
            'NVMe SSD 500GB PCIe 3.0',
            'NVMe SSD 1TB PCIe 3.0',
            'NVMe SSD 1TB PCIe 4.0',
            'NVMe SSD 2TB PCIe 4.0',
            'HDD 1TB 7200RPM',
            'HDD 2TB 7200RPM',
            'NVMe SSD 4TB PCIe 4.0',
            'SSD 4TB SATA',
            'HDD 4TB 5400RPM',
            'NVMe SSD 2TB PCIe 5.0',
            'HDD 8TB 7200RPM',
            'SSD 120GB SATA',
            'NVMe SSD 250GB PCIe 3.0',
            'HDD 500GB 7200RPM',
            'NVMe SSD 500GB PCIe 4.0',
            'HDD 3TB 5400RPM'
        ];
        foreach ($drives as $drive) {
            $modeloId = (strpos($drive, 'Barracuda') !== false) ? 1301 : 1302;
            $this->produtos[$produtoId++] = ['modelo_id' => $modeloId, 'nome' => $drive, 'categoria' => 10];
        }
    }

    public function adicionarProduto(int $id, int $modeloId, string $nome, int $categoriaId): void
    {
        if (!isset($this->produtos[$id])) {
            $this->produtos[$id] = ['modelo_id' => $modeloId, 'nome' => $nome, 'categoria' => $categoriaId];
        }
    }

    public function getProduto(int $id): ?array
    {
        return $this->produtos[$id] ?? null;
    }

    public function listarProdutos(): array
    {
        return $this->produtos;
    }

    public function getNome(int $id): ?string
    {
        return $this->produtos[$id]['nome'] ?? null;
    }

    public function getmodeloId(int $id): ?int
    {
        return $this->produtos[$id]['modelo_id'] ?? null;
    }

    public function getCategoriaId(int $id): ?int
    {
        return $this->produtos[$id]['categoria'] ?? null;
    }

    public function listarProdutosPorCategoria(int $categoriaId): array
    {
        return array_filter($this->produtos, function ($produto) use ($categoriaId) {
            return $produto['categoria'] === $categoriaId;
        });
    }

    public function listarProdutosPorModelo(int $modeloId): array
    {
        return array_filter($this->produtos, function ($produto) use ($modeloId) {
            return $produto['modelo_id'] === $modeloId;
        });
    }

    public function listarProdutosPorNome(string $nome): array
    {
        return array_filter($this->produtos, function ($produto) use ($nome) {
            return stripos($produto['nome'], $nome) !== false;
        });
    }

    public function listarProdutosPorNomeEModelo(string $nome, int $modeloId): array
    {
        return array_filter($this->produtos, function ($produto) use ($nome, $modeloId) {
            return stripos($produto['nome'], $nome) !== false && $produto['modelo_id'] === $modeloId;
        });
    }
}
