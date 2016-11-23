<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{

    protected $fillable = [
        'nome'
        ];

    //
    public function utilizadorservicos(){
        return $this->hasMany('UtilizadorServicos');
    }
}
