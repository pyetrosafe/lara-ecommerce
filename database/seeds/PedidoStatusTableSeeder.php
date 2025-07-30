<?php

use Illuminate\Database\Seeder;

class PedidoStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Aberto',
            'created_at' => now(),
        ]);

        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Confirmado',
            'created_at' => now(),
        ]);

        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Aguardando pagamento',
            'created_at' => now(),
        ]);

        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Pagamento confirmado',
            'created_at' => now(),
        ]);

        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Pedido enviado',
            'created_at' => now(),
        ]);

        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Pedido entregue',
            'created_at' => now(),
        ]);

        DB::table('tbl_pedido_status')->insert([
            'descricao' => 'Cancelado',
            'created_at' => now(),
        ]);
    }
}
