<?php

use Illuminate\Database\Seeder;
use App\Pedido;
use App\Cliente;
use App\Produto;
use App\PedidoStatus;

class PedidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Certifique-se de que existem clientes e produtos para associar
        $clientes = Cliente::all();
        $produtos = Produto::all();
        $pedidoStatuses = PedidoStatus::all();

        if ($clientes->isEmpty() || $produtos->isEmpty() || $pedidoStatuses->isEmpty()) {
            $this->command->info('Clientes, Produtos ou PedidoStatus não encontrados. Execute os seeders correspondentes primeiro.');
            return;
        }

        factory(Pedido::class, 10)->create()->each(function ($pedido) use ($produtos, $pedidoStatuses) {
            // Anexar produtos ao pedido
            $pedido->Produtos()->attach(
                $produtos->random(rand(1, 3))->pluck('id')->toArray(),
                [
                    'valor' => rand(10, 100),
                    'quantidade' => rand(1, 5),
                ]
            );

            // Definir um status de pedido aleatório
            $pedido->id_pedido_status = $pedidoStatuses->random()->id;
            $pedido->save();
        });
    }
}
