<?php

namespace App\Http\Controllers;

use App\TipoMovimentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class TipoMovimentosController extends Controller
{
    public function inserir(Request $request){
        $this->validate($request, [
            'descricao' => 'required',
        ]);

        $tipo_movimentos = new TipoMovimentos();
        $tipo_movimentos->descricao = $request->get('descricao');
        $tipo_movimentos->inserido_por = Auth::user()->id;
        $tipo_movimentos->save();

        return redirect('tipo_movimentos')->with('mensagem','Tipo de Movimento inserido!');
    }

    public function editar(Request $request){
        $tipo_movimentos = TipoMovimentos::find($request->get('id'));
        $tipo_movimentos->descricao = $request->get('descricao');
        $tipo_movimentos->alterado_por = Auth::user()->id;
        $tipo_movimentos->save();

        return redirect('tipo_movimentos')->with('tipo_movimentos',TipoMovimentos::all())->with('mensagem','Tipo de Movimento nr '. $request->get('id')  .' editado!');
    }

    public function apagar(Request $request)
    {
        $tipo_movimentos = TipoMovimentos::find($request->get('id'));
        $tipo_movimentos->forceDelete();
        return redirect('tipo_movimentos')->with('tipo_movimentos',TipoMovimentos::all())->with('mensagem','Tipo de Movimento nr '. $request->get('id')  .' apagado!');
    }

}
