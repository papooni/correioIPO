<?php

use Illuminate\Support\Facades\Input;
use App\User;
use App\UtilizadorServicos;

Route::auth();

Route::get('/', function () {return view('welcome');});

Route::get('login',function(){return view('auth/login');});

Route::get('/password/email', function(){
    return view('auth/passwords/email');
});

Route::group(array('before' => 'auth'), function () {
    Route::get('/logout', 'UserController@logout');//->middleware('auth');

    Route::get('/registar', function () {
        return view('auth/registar');
    });//->middleware('auth');
    Route::post('/registar_utilizador', 'UserController@registar');

    Route::get('/home', function () {
        return view('home');
    });
    Route::get('/entrar', 'UserController@entrar');

    Route::get('/estatistica', 'CorreiosController@estatistica');

    Route::get('/notificacoes', function () {
        $users = User::where('ativo', 1)->get();
        return view('notificacoes')->with('users', $users);
    });
    Route::get('/administradores', function () {
        $users = User::where('ativo', 1)->get();
        return view('administradores')->with('users', $users);
    });
    Route::get('definicoes', function () {
        return view('layouts/definicoes');
    });

    Route::get('utilizadores/pesquisa', 'UserController@pesquisa');
    Route::get('utilizadores/index', 'UserController@index');
    Route::get('utilizadores', 'UserController@index');//->middleware('auth:web');;
    Route::post('utilizadores/editar', 'UserController@editar');
    Route::get('utilizadores/apagar', 'UserController@apagar');
    Route::get('utilizadores/definicoes/{id}', 'UserController@definicoes');
    Route::get('/utilizadores/gravar_definicoes', 'UserController@gravar_definicoes');
    Route::get('/utilizadores/extra', 'UserController@extra');
    Route::get('utilizadores/atribuir_servico', 'UserController@atribuir_servico');
    Route::get('utilizadores/apagarservico', 'UserController@apagarservico');

    Route::get('utilizadores/apagarservicoutilizador', function () {
        $idservico = Input::get('idservico');
        $iduser = Input::get('iduser');

        $data = DB::table('utilizador_servicos')
            ->select('id')
            ->where('user_id', $iduser)
            ->orwhere('servicos_id', $idservico)
            ->get();

        $dados = UtilizadorServicos::where('user_id', $iduser)->where('servicos_id', $idservico)->first();

        $utilizadorservicos = UtilizadorServicos::findOrFail($dados->id);
        $utilizadorservicos->forceDelete();

        /*return Response::json($utilizadorservicos->id);*/
        return Response::json($dados->id);
    });

    Route::get('/tipo_movimentos', function () {
        return view('tipomovimentos/index')->with('tipo_movimentos', App\TipoMovimentos::all());
    });
    Route::post('/tipo_movimentos/inserir', 'TipoMovimentosController@inserir');
    Route::post('/tipo_movimentos/editar', 'TipoMovimentosController@editar');
    Route::get('/tipo_movimentos/apagar', 'TipoMovimentosController@apagar');

    Route::any('/utilizadores/getdatautilizador', function () {
        $return_array[] = array();
        $term = Input::get('term');
        $data = DB::table('users')
            ->select('id', 'nome')
            ->where('id', '=', $term)
            ->orWhere('nome', 'like', '%' . $term . '%')
            //->where('id','!=',Auth::id())
            ->where('ativo', 1)
            ->take(10)
            ->get();
        foreach ($data as $v) {
            $return_array[] = array('value' => $v->id . ' - ' . $v->nome);
        }
        return Response::json($return_array);
    });
    Route::any('/correios/getdatacorreio', function () {
        $return_array[] = array();
        $term = Input::get('term');
        $data = DB::table('correios')
            ->select('id', 'assunto')
            ->where('id', '=', $term)
            ->orWhere('assunto', 'like', '%' . $term . '%')
            ->take(10)
            ->get();
        foreach ($data as $v) {
            $return_array[] = array('value' => $v->id . ' - ' . $v->assunto);
        }
        return Response::json($return_array);
    });

    Route::get('/utilizadores/servicos', function () {
        $term = Input::get('id');
        $data = DB::table('utilizador_servicos')
            ->join('servicos', 'servicos.id', '=', 'utilizador_servicos.servicos_id')
            ->select('servicos.id', 'servicos.nome')
            ->where('user_id', '=', $term)
            ->get();
        return Response::json($data);
    });

    Route::get('/utilizadores/notificacoes', 'UserController@notificacoes');

    Route::get('/utilizadores/administradores', 'UserController@administradores');

    Route::get('/servicos/utilizadores', function () {
        $servico_id = Input::get('servico_id');
        $data = DB::table('utilizador_servicos')
            ->join('users', 'users.id', '=', 'utilizador_servicos.user_id')
            ->select('*')
            ->where('servicos_id', '=', $servico_id)
            ->get();
        return Response::json($data);
    });

    Route::any('/servicos/getdataservico', function () {
        $return_array[] = array();
        $term = Input::get('term');
        $data = DB::table('servicos')
            ->select('id', 'nome')
            ->where('id', '=', $term)
            ->orWhere('nome', 'like', '%' . $term . '%')
            ->take(10)
            ->get();
        foreach ($data as $v) {
            $return_array[] = array('value' => $v->id . ' - ' . $v->nome);
        }
        return Response::json($return_array);
    });

    Route::get('/correios/registar', function () {
        return view('correios/registar_correio2')
            ->with('utilizadores', App\User::all())
            ->with('servicos', App\Servicos::all())
            ->with('tipomovimento', App\TipoMovimentos::all());
    });
    Route::post('/correios/gravar', 'CorreiosController@gravar');
    Route::post('correios/gravar2', 'CorreiosController@gravar2');
    Route::get('/correios/index', 'CorreiosController@index');
    Route::get('/correios/reenvio/{id}', 'CorreiosController@reenvio');
    Route::get('/correios/detalhes/{id}', 'CorreiosController@detalhes');
    Route::post('/correios/reenvio_correio/{id}', 'CorreiosController@gravar_reenvio');
    Route::get('/correios/meu_correio', 'CorreiosController@meu_correio');
    Route::get('/correios/pesquisa', 'CorreiosController@pesquisa');
    Route::post('/correios/apagar', 'CorreiosController@apagar');

    /*Route::get('/correios/index',function(){
        //return view('correios/index')->with('correios',App\Correios::paginate(15)->movimentos());
        return view('correios/index')->with('correios',App\Movimentos::has('correios')->has('tipomovimentos')->has('users')->paginate(10));
        });*/

    Route::get('servicos/index', function () {
        $ordena = Input::get('ordena');

        if(is_null($ordena)){
            $ordena = 'id';
        }
        return view('servicos/index')
            ->with('servicos', App\Servicos::orderBy($ordena)
                ->paginate(10));
    });
    Route::post('servicos/inserir', 'ServicosController@inserir');
    Route::post('servicos/editar', 'ServicosController@editar');
    Route::post('servicos/apagar', 'ServicosController@apagar');
    Route::get('servicos/pesquisa', 'ServicosController@pesquisa');
});