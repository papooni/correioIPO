<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Movimentos;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nr_mecanografico',
        'notificacoes',
        'admin',
        'inserido_por'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function tipomovimentos(){
        return $this->hasMany('TipoMovimentos');
    }

    public function movimentos(){
        return $this->hasMany('Movimentos');
    }

    public function utilizadorservicos(){
        return $this->hasMany('Utilizadorservicos');
    }

    public function correioNaoLido()
    {
        return Movimentos::where('colaborador_destino', $this->id)->where('lido', 0)->get();
    }

    public function getNome(){

        return User::where('id', $this->id)->nome;
    }

}
