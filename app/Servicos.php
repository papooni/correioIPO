<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    //
    public function utilizadorservicos(){
        return $this->hasMany('UtilizadorServicos');
    }
}
