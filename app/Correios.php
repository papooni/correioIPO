<?php

namespace App;

use App\Movimentos;
use Illuminate\Database\Eloquent\Model;

class Correios extends Model
{
    protected $fillable = [
        'assunto',
        'observacoes',
        'inserido_por'
    ];

    // Um determinado correio pode ter varios movimentos
    public function movimentos(){
        return $this->hasMany('App\Movimentos');
    }

    public function tipomovimento($id){
        var_dump($id);
        return TipoMovimentos::find($id)->first()->descricao;
    }
}