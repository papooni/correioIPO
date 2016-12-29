<?php

namespace App\Http\Controllers;

use App\Servicos;
use App\UtilizadorServicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


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

        $utilizadorservico = UtilizadorServicos::where('servicos_id','=',$request->get('id'))->get();

        if(count($utilizadorservico) > 0){

            return redirect('servicos/index')->with('erro','Não Pode Apagar! Existem Utilizadores Associados a este serviço!');
        }
        else{
            $servico = Servicos::find($request->get('id'));
            $servico->forceDelete();
            return redirect('servicos/index')->with('servicos',Servicos::all())->with('mensagem','Serviço ' .$request->get('id') . '  ' .$request->get('nome')   .' Apagado!');
        }





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
            $servicos = Servicos::findorFail($id_servico);
            return view('servicos/index')->with('servicos',$servicos);
        }
        else{
            $servicos = Servicos::paginate(10);
            return view('servicos/index')->with('servicos',$servicos);
        }

    }

    public function index(Request $request)
    {
        $ordena = Input::get('ordena');
        $tipo = Input::get('tipo');

        if (is_null($ordena)){
            $ordena = 'id';
        }

        return view('servicos/index')
            ->with('servicos', Servicos::orderBy($ordena)->paginate(10))
            ->with('ordena',$ordena)
            ->with('tipo',$tipo);
    }
}
