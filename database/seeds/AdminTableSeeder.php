<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tbl_admin')->insert([
            'id_usuario' => 1,
            'nome' => 'Administrador Senior',
            'created_at' => 'now()',
        ]);
    }
}
