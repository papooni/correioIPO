<?php

namespace App\Http\Controllers;

use App\Correios;
use App\User;
use App\UtilizadorServicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{

    /* public function __construct()
     {
         $this->middleware('auth:api');
     }*/

    public function index(){
        return view('utilizadores/index')
            ->with('servicos_utilizador',UtilizadorServicos::paginate(10))
            ->with('utilizadores',User::where('id','!=',Auth::id())->where('ativo',1)->paginate(10))
            ->with('titulo','Utilizadores');
    }

    public function extra(){
        return view('utilizadores/index')
            ->with('servicos_utilizador',UtilizadorServicos::paginate(10))
            ->with('utilizadores',User::where('ativo',0)->paginate(10))->with('titulo','Utilizadores Extra');
    }

    public function registar(Request $request){
        $this->validate($request, [
            'nr_mecanografico' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->nome = $request['nome'];
        $user->email = $request['email'];
        $user->nr_mecanografico = $request['nr_mecanografico'];
        $user->password = bcrypt($request['password']);
        $user->inserido_por =  Auth::user()->id;
        if ($request->administrador != 1){
            $admin = 0;
        }else{
            $admin = $request->administrador;
        }
        $user->admin = $admin;
        //var_dump($request->administrador);
        $user->save();
        return redirect('home')->with('novo','Utilizador Adicionado com Sucesso!');
    }

    public function editar(Request $request){
        $user = User::findOrFail($request->get('mid'));
        $user->nome = $request->get('mnome');
        $user -> email = $request->get('memail');
        $user -> nr_mecanografico =  $request->get('mnr');
        $user -> alterado_por = Auth::user()->id;
        $user->save();
        return redirect('utilizadores/index')->with('utilizadores',User::all())->with('mensagem','Utilizador ' .$request->get('mid')   .' Alterado!');
    }

    public function apagar(Request $request){
        $user = User::findorFail($request->get('mid'));
        $user->forceDelete();
        return redirect('utilizadores/index')->with('utilizadores',User::all())->with('mensagem','Utilizador ' .$request->get('mid')   .' Apagado!');
    }

    public function pesquisa(Request $request){
        if (!empty($request->pesquisa_utilizador)  ){
            $id_utilizador = explode("-",$request->pesquisa_utilizador);
            $id_utilizador = str_replace(" ","", $id_utilizador);
            $utilizadores = User::find($id_utilizador);

            return view('utilizadores/index')
                ->with('servicos_utilizador',UtilizadorServicos::paginate(10))
                ->with('utilizadores',$utilizadores)
                ->with('titulo','Pesquisa Utilizadores 5');
        }else{
            $utilizadores = User::where('id','!=',Auth::id())->where('ativo',1)->paginate(10);
            return redirect('utilizadores/index')
                ->with('utilizadores',$utilizadores)
                ->with('titulo','Pesquisa Utilizadores')
                ->with('erro','Erro de Pesquisa');
        }
    }

    public function definicoes(Request $request){
        $user = User::findOrFail($request->id);

        if ($user->id != Auth::user()->id){

            return redirect('/utilizadores/index')->with('erro','Não tem Permissão para alterar dados que não lhe pertencem!');
        }else {
            return view('utilizadores/definicoes')->with('user',$user);
        }


    }

    public function gravar_definicoes(Request $request){
        $user = Auth::user();
        $this->validate($request, [
            'nr_mecanografico' => ['required',Rule::unique('users')->ignore($user->id, 'id')],
            'email' => ['required',Rule::unique('users')->ignore($user->id, 'id')]
//            'password' => 'sometimes|required|password|min:6|confirmed',
        ]);
        $user = User::findOrFail( Auth::user()->id);
        $user->nome = $request->get('nome');
        $user -> email = $request->get('email');
        $user -> nr_mecanografico =  $request->get('nr_mecanografico');
        $user -> alterado_por = Auth::user()->id;
        $user->save();


        return redirect('home')->with('novo','Utilizador Atualizado!');
    }

    public function atribuir_servico(Request $request){
        $user = User::findOrFail($request->get('mid'));
        $servico = $request->get('servico');
        $utilizador_servicos = new UtilizadorServicos();
        $utilizador_servicos->user_id = $user->id;
        $utilizador_servicos->servicos_id = $servico;
        $utilizador_servicos->save();

        return redirect('utilizadores/index')->with('utilizadores',User::paginate(10))->with('mensagem','Foi atribuído com sucesso o serviço'. $servico .' ao utilizador' . $user->id );
    }

    public function notificacoes(){
        $user_id = Input::get('id');
        $estado = Input::get('estado');
        $user = User::findOrFail($user_id);
        $estado_inicial = $user->notificacoes;
        if ($estado == 'true') {
            $estado = 1;
        }
        if($estado == 'false'){
            $estado = 0;
        }
        if ($user->notificacoes != $estado){
            if ($estado == true) {
                $user->notificacoes = true;
            }
            if($estado == false){
                $user->notificacoes = false;
            }
            $mensagem = 'Estado Diferente';
        }
        else{
            $mensagem = 'Estado Igual';
        }
        $user->save();
        $data = ['MENSAGEM',$mensagem,'ID USER -> '. $user_id,'ESTADO INICIAL - > '.$estado_inicial,'ESTADO FINAL -> '.$estado];
        return Response::json($data);
    }

    public function administradores(){
        $user_id = Input::get('id');
        $estado = Input::get('estado');
        $user = User::findOrFail($user_id);
        $estado_inicial = $user->admin;
        if ($estado == 'true') {
            $estado = 1;
        }
        if($estado == 'false'){
            $estado = 0;
        }
        if ($user->admin != $estado){
            if ($estado == true) {
                $user->admin = true;
            }
            if($estado == false){
                $user->admin = false;
            }
            $mensagem = 'Estado Diferente';
        }
        else{
            $mensagem = 'Estado Igual';
        }
        $user->admin = $estado;
        $user->save();
        $data = ['MENSAGEM',$mensagem,'ID USER -> '. $user_id,'ESTADO INICIAL - > '.$estado_inicial,'ESTADO FINAL -> '.$estado];
        return Response::json($data);
    }

    ///////////////////////////////////////////////////////

    public function entrar(Request $request){

        $this->validate($request, [
            'nr_mecanografico' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($request->ligacao == 0 ){
            //NORMAL
            return $this->login_normal($request);
        }elseif ($request->ligacao == 1 ){
            //ACTIVE DIRECTORY
            return $this->login_ad($request);
        }elseif($request->ligacao == 2 ){
            //SINGLE SIGN ON
            return $this->login_sso($request);
        }else{
            return view('/welcome');
        }

    }

    public function login_normal($request){
        if (Auth::attempt(['nr_mecanografico' => $request->nr_mecanografico, 'password' => $request->password]))
        {
            return redirect()->intended('home');
        }else{
            return redirect('login')->with('mensagem','ERRO DE LOGIN');
        }
    }

    public function login_ad($request){

    }

    public function login_sso($request){

    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }


}
