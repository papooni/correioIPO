<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimentos extends Model
{
    //
    public function movimentos(){
        return $this->hasMany('App\Movimentos');
    }

   /* public function user(){
        return $this->hasOne('User');
    }*/

}
