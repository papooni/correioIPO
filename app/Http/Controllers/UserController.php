<?php

namespace App\Http\Controllers;

use App\Correios;
use App\Servicos;
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

    /*     public function __construct()
         {
             $this->middleware('auth');
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
            ->with('utilizadores',User::where('ativo',0)->paginate(10))->with('titulo','Utilizadores Externos');
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
        $ativo = $request->interno;
        if (is_null($ativo)){
            $ativo = 0;
        }else{
            $ativo = 1;
        }
        $user-> ativo = $ativo;
        $user -> alterado_por = Auth::user()->id;
        //var_dump($ativo .' - '. $request->interno);
        $user->save();
        return redirect('utilizadores/index')->with('utilizadores',User::all())->with('mensagem','Utilizador ' .$request->get('mid').  ' ' . $user->nome .' Alterado!');
    }

    public function apagar(Request $request){
        $user = User::findorFail($request->get('mid'));
        $user->forceDelete();
        $user->utilizadorservicos()->delete();

        return redirect('utilizadores/index')
            ->with('utilizadores',User::all())
            ->with('mensagem','Utilizador '.$request->get('mid').' '. $user->nome .'  Apagado!');
    }

    public function pesquisa(Request $request){
        if (!empty($request->pesquisa_utilizador)  ){
            $id_utilizador = explode("-",$request->pesquisa_utilizador);
            $id_utilizador = str_replace(" ","", $id_utilizador);
            $utilizadores = User::findorFail($id_utilizador);

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
        $servicos = \App\User::find($user->id)->utilizadorservicos()->get();

        if ($user->id != Auth::user()->id){
            return redirect('/utilizadores/index')->with('erro','Não tem Permissão para alterar dados que não lhe pertencem!');
        }else {
            return view('utilizadores/definicoes')->with('user',$user)->with('servicos', $servicos);
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
        $this->validate($request,[
            'servico' => 'required'
        ]);

        $user = User::findOrFail($request->get('mid'));
        $servico = $request->get('servico');
        $servicoObj = Servicos::findOrFail($servico);

        if (count(UtilizadorServicos::where('user_id','=',$user->id)->where('servicos_id','=', $servicoObj->id)->get()) >0 ){
            return redirect('utilizadores/index')
                ->with('utilizadores',User::paginate(10))
                ->with('erro','Serviço já atribuído a esse utilizador' );
        }else{
            $utilizador_servicos = new UtilizadorServicos();
            $utilizador_servicos->user_id = $user->id;
            $utilizador_servicos->servicos_id = $servico;
            $utilizador_servicos->save();

            return redirect('utilizadores/index')
                ->with('utilizadores',User::paginate(10))
                ->with('mensagem','Foi atribuído com sucesso o serviço '. $servicoObj->nome .' ao utilizador ' . $user->nome );
        }
    }

    public function apagarservico(Request $request){
        $utilizadorservicos = UtilizadorServicos::findOrFail($request->idutilizadorservico);
        $utilizadorservicos->forceDelete();
        return redirect('utilizadores/definicoes/'.$utilizadorservicos->user_id)->with('mensagem','Servico Apagado');
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
        }elseif($request->ligacao == 2 ) {
            //SINGLE SIGN ON
            return $this->login_sso($request);
        }else{
            return view('/welcome');
        }
    }

    public function login_normal($request)
    {
        $remember = $request->remember;

        if (Auth::attempt(['nr_mecanografico' => $request->nr_mecanografico, 'password' => $request->password],$remember)) {
            return redirect()->intended('home')->with('novo', 'Olá ' . Auth::user()->nome);
        } else {
            return redirect('login')->with('mensagem', 'ERRO DE LOGIN');
        }
    }

    public function login_sso($request){
        $ligacao = '';
        //BD Oracle
        //Dados de ligação à base de dados oracle
        $user = "portal_hlp";
        $password = "AAAAAAAAAAAAAAAAAAAAAAAAA";
        //service name e descrição
        $db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=ipophasif.ipoporto.min-saude.pt)(PORT=1521))
                (CONNECT_DATA=(SERVER=dedicated)(SERVICE_NAME=infra.ipoporto.min-saude.pt)))";
        //conexão à bd oracle
        $connect = oci_connect($user, $password, $db);

        $nis = '';
        $sessionid = '';
        $table = mysqli_select_db($ligacao,"plano_contingencia");
        //data actual
        date_default_timezone_set("Europe/Lisbon");
        $data =date("Y-m-d H:i:s");
        //query para verificar se existe
        $query = "SELECT * from PORTAL_SSO_SIIMA WHERE USER_ID='".$nis."' and SESSION_ID='".$sessionid."'";
        $result = oci_parse($connect, $query);
        //executa a query
        oci_execute($result);
        $tmpcount = oci_fetch($result);
        //se ecnontrar alguma linha guardar as variaveis de sessão
        if ($tmpcount==1) {
            $_SESSION['login_user'] = $nis;
            $_SESSION['session_id'] = $sessionid;
            //grava um novo acesso na tabela de acessos
           // $queryAcesso = "INSERT INTO acesso (num_mec, data_acesso) VALUES ('$nis', '$data')";
            //$query = mysqli_query($ligacao, $queryAcesso);
            //query para destruir o token logo mal inicia a sessão
            $queryDelete = "DELETE from PORTAL_SSO_SIIMA WHERE USER_ID='".$nis."' and SESSION_ID='".$sessionid."'";
            $result = oci_parse($connect, $queryDelete);
            //executa a query
            oci_execute($result);
        } else {
            //algo na conexão falhou
            echo "O login Falhou";
        }
        //fecha ligações
        oci_close($connect);
        //mysqli_close($ligacao);
        return redirect('login')->with('mensagem','LOGIN SSO');
    }

    public function login_ad($request){
        $ligacao = '';
        //$table = mysqli_select_db($ligacao,"plano_contingencia");
        $user = $request->nr_mecanografico;
        $pass = $request->password;
        date_default_timezone_set("Europe/Lisbon");
        $data =date("Y-m-d H:i:s");
        //Endereco do servido AD IP ou nome
        $servidor_AD = "192.168.2.160";
        //$servidor_AD = "ipophasif.ipoporto.min-saude.pt";
        //Domínio
        $dominio = "porto.local";
        // Conexão com servidor AD.
        $ad = ldap_connect($servidor_AD);
        if ($ad) {
            // Versao do protocolo
            ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
            // Usara as referencias do servidor AD, neste caso nao
            ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
            // Bind
            $bd = ldap_bind($ad, $user . "@" . $dominio, $pass);
            $basedn = 'dc=porto,dc=local';
            $userdn = getDN($ad, $user, $basedn);
            //grupo permitido
            $group ="internetaccess";
            if (checkGroupEx($ad, $userdn, getDN($ad, $group, $basedn))) {
                $autorizado=true;
            } else {
                $autorizado=false;
            }
            if (($bd) and ($autorizado==true)) {
                $_SESSION['login_user'] = $user;
                //grava um novo acesso na tabela de acessos
                //$queryAcesso = "INSERT INTO acesso (num_mec, data_acesso) VALUES ('$user', '$data')";
                //$query = mysqli_query($ligacao, $queryAcesso);
            } else {
                $error= "Número Mecanográfico ou Password inválido!";
            }
        } else {
            $error = "Nao Conectado no servidor";
        }
        ldap_unbind($ad);

        return redirect('login')->with('mensagem','LOGIN AD');
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }


}
