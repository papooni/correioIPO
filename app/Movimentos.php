<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimentos extends Model
{
    protected $fillable = [
        'correios_id',
        'tipo_movimentos_id',
        'observacoes',
        'colaborador_origem',
        'servico_origem',
        'colaborador_destino',
        'servico_destino',
        'recebido_por',
        'inserido_por',
        'alterado_por',
    ];

    //um movimento pertence a um determinado correio
    public function correio(){
        return $this->belongsTo('App\Correios');
    }
    //um movimento tem um tipo de movimento
    public function tipomovimento(){
        return $this->belongsTo('App\TipoMovimentos');
    }

    public function users(){
        return $this->belongsTo('App\User');
    }

    public function getNomeUtilizador($id){

        return User::where('id', $id)->first()->nome;
    }

    public function getNomeServico($id){

        return Servicos::where('id', $id)->first()->nome;
    }
}
