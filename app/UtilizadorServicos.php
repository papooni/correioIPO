<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UtilizadorServicos extends Model
{
    //

    public function servico(){
        return $this->belongsTo('App\Servicos');
    }

    public function utilizador(){
        return $this->belongsTo('App\User');
    }



}
