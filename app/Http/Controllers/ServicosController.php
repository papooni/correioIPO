<?php

namespace App\Http\Controllers;

use App\Servicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicosController extends Controller
{
    public function inserir(Request $request){
        $this->validate($request, [
            'nome' => 'required',
        ]);

        $servico = new Servicos();
        $servico->nome = $request->get('nome');
        $servico->inserido_por = Auth::user()->id;
        $servico->save();

        return redirect('servicos/index')->with('mensagem','Serviço inserido!');
    }

    public function apagar(Request $request){
        $servico = Servicos::find($request->get('id'));
        $servico->forceDelete();
        return redirect('servicos/index')->with('servicos',Servicos::all())->with('mensagem','Serviço ' .$request->get('id') . '  ' .$request->get('nome')   .' Apagado!');
    }

    public function editar(Request $request){
        $servico = Servicos::find($request->get('id'));
        $servico->nome = $request->get('nome');
        $servico->alterado_por = Auth::user()->id;
        $servico->save();
        return redirect('servicos/index')->with('servicos',Servicos::all())->with('mensagem','Serviço ' .$request->get('id')   .' Alterado!');
    }

    public function pesquisa(Request $request){

        if (!empty($request->pesquisa_servico)){
            $id_servico = explode("-",$request->pesquisa_servico);
            $id_servico = str_replace(" ","", $id_servico);
            $servicos = Servicos::find($id_servico);
            return view('servicos/index')->with('servicos',$servicos);
        }
        else{
            $servicos = Servicos::paginate(10);
            return view('servicos/index')->with('servicos',$servicos);
        }

    }

}
