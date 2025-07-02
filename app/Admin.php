<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_admin';

    public function user() {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}
