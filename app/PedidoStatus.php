<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoStatus extends Model
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_pedido_status';

    public function Pedido() {
        return $this->hasMany('App\Pedido', 'id_pedido_status');
    }
}
