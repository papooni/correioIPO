<?php

namespace App\Http\Controllers;

use App\Servicos;
use App\TipoMovimentos;
use App\Correios;
use App\Movimentos;
use App\User;
use App\UtilizadorServicos;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;


class CorreiosController extends Controller
{

    /* public function __construct()
     {
         $this->middleware('auth:api');
     }*/

    public function apagar(Request $request){
        var_dump('APAGAR CORREIO ' . $request->id );
        $correio = Correios::findorFail($request->id);
        $correio->forceDelete();
        $correio->movimentos()->delete();

        return redirect('/correios/index')->with('mensagem','Correio Apagado!');
    }

    public function gravar(Request $request){

        $this->validate($request, [
            'assunto' => 'required',
            'observacoes' => 'required',
            'tipomovimento' => 'required|not_in:Escolha Tipo : ',
            'servico_origem' => 'required',
            'colaborador_origem'  => 'required',
            'servico_destino' => 'required',
            'colaborador_destino' => 'required',
        ]);

        $user = Auth::user();
        $tipo_movimento = TipoMovimentos::find($request->get('tipomovimento'));//recebe o numero (id) é preciso verificar e ir buscar a descricao
        $nome_user = $user->nome;
        $nome_movimento = $tipo_movimento->descricao;
        $colaborador_origem = $request->get('colaborador_origem');
        $servico_origem = $request->get('servico_origem');
        $colaborador_destino = $request->get('colaborador_destino');
        $servico_destino = $request->get('servico_destino');

        //Criar Correio novo
        $idnovo = Correios::create([
            'assunto' => $request->get('assunto'),
            'observacoes' => $request->get('observacoes'),
            'inserido_por' => $user->id
        ])->id;

        //var_dump($idnovo . $tipo_movimento->id);
        //Criar Movimento novo associado ao id co correio anterior
        Movimentos::create([
            'correios_id' => $idnovo,
            'tipo_movimentos_id' => $tipo_movimento->id,
            //campo observacoes recebe o mesmo valor da tabela correio
            'observacoes' => $request->get('observacoes'),
            'colaborador_origem' => $colaborador_origem,
            'servico_origem' => $servico_origem,
            'colaborador_destino' => $colaborador_destino,
            'servico_destino' => $servico_destino,
            'inserido_por' => Auth::user()->id,
            'recebido_por' => Auth::user()->id,
            'recebido_em' => Carbon::now()
        ]);

        $title = 'NOVA ' . strtoupper($nome_movimento) . ' DE CORREIO ID -> ' .$idnovo;
        $content = 'TESTE';
        $emails_to = ['8030083@gmail.com'];

        //Enviar Email
        /* Mail::send(array('html' => 'emails.send'), ['title' => $title, 'content' => $content], function ($message) use ($user, $emails_to, $title) {
             $message->from('app@mail.pt', 'Gestão Correio Interno IPO');
             $message->to($emails_to);
             //$message->attach($attach);
             $message->subject($title);
         });*/

        return redirect('correios/index')->with('mensagem',$tipo_movimento->descricao . ' com o Nr. '.$idnovo .' de Correio Registada  '  );
    }

    public function gravar2(Request $request){

        $this->validate($request, [
            'assunto' => 'required',
            'observacoes' => 'required',
            'tipomovimento' => 'required|not_in:Escolha Tipo : ',
            'servico_origem' => 'required',
            'colaborador_origem'  => 'required',
            'servico_destino' => 'required',
            'colaborador_destino' => 'required',
        ]);

        $user = Auth::user();
        $tipo_movimento = TipoMovimentos::findorFail($request->get('tipomovimento'));//recebe o numero (id) é preciso verificar e ir buscar a descricao

        $origem = $this->getIds($request->get('servico_origem'),$request->get('colaborador_origem'));
        $destino = $this->getIds($request->get('servico_destino'),$request->get('colaborador_destino'));

        $servico_origem = $origem[0];
        $colaborador_origem = $origem[1];
        $servico_destino = $destino[0];
        $colaborador_destino = $destino[1];

        //var_dump('<br> SERVIÇO ORIGEM -'.$origem[0] . ' COLABORADOR ORIGEM - ' . $origem[1]);
        //var_dump('<br> SERVIÇO DESTINO -'.$destino[0] . ' COLABORADOR DESTINO - ' . $destino[1]);

        //Criar Correio novo
        $idnovo = Correios::create([
            'assunto' => $request->get('assunto'),
            'observacoes' => $request->get('observacoes'),
            'inserido_por' => $user->id
        ])->id;

        //Criar Movimento novo associado ao id com correio anterior
        Movimentos::create([
            'correios_id' => $idnovo,
            'tipo_movimentos_id' => $tipo_movimento->id,
            //campo observacoes recebe o mesmo valor da tabela correio
            'observacoes' => $request->get('observacoes'),
            'colaborador_origem' => $colaborador_origem,
            'servico_origem' => $servico_origem,
            'colaborador_destino' => $colaborador_destino,
            'servico_destino' => $servico_destino,
            'inserido_por' => Auth::user()->id,
            'recebido_por' => Auth::user()->id,
            'recebido_em' => Carbon::now()
        ]);

        $observacoes = $request->get('observacoes');
        $title = 'NOVA ' . strtoupper($tipo_movimento->descricao) . ' DE CORREIO ';

        $content =  '
                <html>
                <body>
                <table style="margin-top:10px;border: 1px solid black;">
                        <tr style="border: 1px solid black;">
                                <th rowspan="2" style="text-align: center;vertical-align: middle;border: 1px solid black;">OBSERVAÇÕES</th>
                                <td colspan="2" style="text-align: center;font-weight: bold;border: 1px solid black;">ORIGEM</td>
                                <td colspan="2" style="text-align: center;font-weight: bold;border: 1px solid black;">DESTINO</td>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;border: 1px solid black;">DATA</th>
                        </tr>
                        <tr style="text-align: center;border: 1px solid black;">
                                <th style="text-align: center;border: 1px solid black;">Colaborador</th>
                                <th style="text-align: center;border: 1px solid black;">Serviço</th>
                                <th style="text-align: center;border: 1px solid black;">Colaborador</th>
                                <th style="text-align: center;border: 1px solid black;">Serviço</th>
                            </tr>
                        <tr style="text-align: center;border: 1px solid black;">
                            <td style="text-align: center;border: 1px solid black;">'. $observacoes.'</td>
                            <td style="text-align: center;border: 1px solid black;">'.User::findorFail($colaborador_origem)->nome.'</td>
                            <td style="text-align: center;border: 1px solid black;">'.Servicos::findorFail($servico_origem)->nome .'</td>
                            <td style="text-align: center;border: 1px solid black;">'.User::findorFail($colaborador_destino)->nome.'</td>
                            <td style="text-align: center;border: 1px solid black;">'.Servicos::findorFail($servico_destino)->nome .'</td>
                            <td style="text-align: center;border: 1px solid black;">'. Carbon::now().'</td>
                        </tr>
                </table>
                </body>
            </html>
                ';
        $emails_to = ['8030083@gmail.com'];

        //Enviar Email
        try{
            Mail::send(array('html' => 'emails.send'), ['title' => $title, 'content' => $content], function ($message) use ($user, $emails_to, $title) {
                $message->from('app@mail.pt', 'Gestão Correio Interno IPO');
                $message->to($emails_to);
                //$message->attach($attach);
                $message->subject($title);
            });
        }catch(Exception $exception){
            $erro = $exception;
        }

        return redirect('correios/index')->with('mensagem',$tipo_movimento->descricao . ' com o Nr. '.$idnovo .' de Correio Registada. ERRO->  '. $erro   );
    }

    public function getIds($servicoinput , $colaborador){

        if (is_numeric($servicoinput)){
            if (is_numeric($colaborador)){
                //EXISTEM OS DOIS
                //DEVOLVER OS IDS DO SERVICO E DO UTILIZADOR JÁ EXISTENTES
                $servico = Servicos::findOrFail($servicoinput);
                $user = User::findOrFail($colaborador);
                $id_servico = $servico->id;
                $id_utilizador = $user->id;
            }
            else{
                //EXISTE O SERVICO
                //CRIAR NOVO UTILIZADOR
                $servico = Servicos::findOrFail($servicoinput);
                $user = new User();
                $user->nome = $colaborador;
                $user->nr_mecanografico = 'IPO'.rand(1,9999);//nr aleatorio
                $colaborador = $this->limparString($colaborador);
                $colaborador = strtolower(str_replace(' ','',$colaborador));
                $user->email = $colaborador.$user->nr_mecanografico.'@mail.pt';//combinacao pois o campo é unico na BD
                $user->password = bcrypt('123456');
                $user->inserido_por =  Auth::user()->id;
                $user->admin = 0;
                $user->ativo = 0;
                $user->save();

                //CRIAR RELAÇÃO- NOVO USER COM SERVICO JA EXISTENTE
                $user = User::findOrFail($user->id);
                $utilizador_servicos = new UtilizadorServicos();
                $utilizador_servicos->user_id = $user->id;
                $utilizador_servicos->servicos_id = $servico->id;
                $utilizador_servicos->save();

                $id_utilizador = $user->id;
                $id_servico = $servico->id;
            }
        }
        else{
            if (is_numeric($colaborador)){
                //CRIAR NOVO SERVICO
                $servico = new Servicos();
                $servico->nome = $servicoinput;
                $servico->inserido_por = Auth::user()->id;
                $servico->save();

                ////CRIAR RELAÇÃO- NOVO SERVICO COM USER JA EXISTENTE
                $user = User::findOrFail($colaborador);
                $utilizador_servicos = new UtilizadorServicos();
                $utilizador_servicos->user_id = $user->id;
                $utilizador_servicos->servicos_id = $servico->id;
                $utilizador_servicos->save();

                $id_utilizador =  $user->id;
                $id_servico = $servico->id;
            }
            else{
                //CRIAR NOVO SERVIÇO E NOVO UTILIZADOR
                $servico = new Servicos();
                $servico->nome = $servicoinput;
                $servico->inserido_por = Auth::user()->id;
                $servico->save();
                //CRIAR NOVO UTILIZADOR
                $user = new User();
                $user->nome = $colaborador;
                $user->nr_mecanografico = 'IPO'.rand(1,9999);
                $colaborador = $this->limparString($colaborador);
                $colaborador = strtolower(str_replace(' ','',$colaborador));
                $user->email = $colaborador.$user->nr_mecanografico.'@mail.pt';//combinacao pois o campo é unico na BD
                $user->password = bcrypt('123456');
                $user->inserido_por =  Auth::user()->id;
                $user->admin = 0;
                $user->ativo = 0;
                $user->save();

                ////CRIAR RELAÇÃO- NOVO SERVICO COM NOVO USER
                $utilizador_servicos = new UtilizadorServicos();
                $utilizador_servicos->user_id = $user->id;
                $utilizador_servicos->servicos_id = $servico->id;
                $utilizador_servicos->save();

                $id_utilizador = $user->id;
                $id_servico = $servico->id;
            }
        }

        /////FALTA CRIAR AS RELACOES DOS SERVICOS NOVOS E UTILIZADORES NOVOS
        return array($id_servico , $id_utilizador);
    }

    public function limparString($texto) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $texto);
    }

    public function index(){
        $correios = Correios::orderBy('created_at','desc')->paginate(10);
        //return View::make('correios/index')->with('correios',$correios);
        return view('correios/index')->with('correios',$correios);
    }

    public function detalhes(Request $request){

        $correio = Correios::findOrFail($request->id);
        $movimentos = Movimentos::where('correios_id', $correio->id)->get();

        $lido =  Movimentos::where('correios_id', $correio->id)->orderBy('created_at','desc')->first();
        $lido->lido = 1;
        $lido->save();

        return view('correios/detalhes')->with('correio',$correio)->with('movimentos',$movimentos);
    }

    public function reenvio(Request $request){
        $correio = Correios::findOrFail($request->id);
        $movimentos = Movimentos::where('correios_id', $correio->id)->get();
        $ultimo_movimento = Movimentos::where('correios_id', $correio->id)->orderBy('created_at','desc')->first()->tipo_movimentos_id;


        return view('correios/reenvio')->with('correio',$correio)->with('tipo',$ultimo_movimento)->with('servicos',Servicos::all())->with('utilizadores',User::all())->with('movimentos',$movimentos);
    }

    public function meu_correio(){
        $correios = Correios::orderBy('created_at','desc')->get();//->movimentos()->where('inserido_por',Auth::user()->id);
        //$correios = Correios::where('inserido_por','=',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('correios/meu_correio')->with('correios',$correios);
    }

    public function gravar_reenvio(Request $request)
    {
        $correio = Correios::findOrFail($request->id);
        $ultimo_movimento = Movimentos::where('correios_id', $correio->id)->orderBy('created_at','desc')->first()->tipo_movimentos_id;

        if($ultimo_movimento == 1){
            $movimento= 'Entrada';
            $novo_tipo_movimento = 2;
        }
        elseif($ultimo_movimento == 2) {
            $movimento= 'Saída';
            $novo_tipo_movimento = 1;
        }

        Movimentos::create([
            'correios_id' => $correio->id,
            'tipo_movimentos_id' => $novo_tipo_movimento ,
            'observacoes' => $request->get('observacoes'),
            'colaborador_origem' => $request->colaborador_origem ,
            'servico_origem' => $request->servico_origem,
            'colaborador_destino' => $request->colaborador_destino,
            'servico_destino' => $request->servico_destino,
            'inserido_por' => Auth::user()->id,
            'recebido_por' => Auth::user()->id,
            'recebido_em' => Carbon::now()
        ]);

        $user = Auth::user();
        $title = 'REENVIO DE CORREIO - NOVA ' . strtoupper($movimento);
        $content = 'TESTE';
        $emails_to = ['8030083@gmail.com'];

        //Enviar Email
        Mail::send(array('html' => 'emails.send'), ['title' => $title, 'content' => $content], function ($message) use ($user, $emails_to, $title) {
            $message->from('app@mail.pt', 'Gestão Correio Interno IPO');
            $message->to($emails_to);
            //$message->attach($attach);
            $message->subject($title);
        });

        return redirect('correios/index')->with('mensagem','Foi registado uma ' . $movimento  .  ' do Correio  ' .$correio->id );

    }

    public function estatistica(){

        $now= Carbon::now();
        $ano = $now->year;

        $janeiro = Correios::whereBetween('created_at',[$ano.'/01/01',$ano.'/01/31'])->count();
        $fevereiro = Correios::whereBetween('created_at',[$ano.'/02/01',$ano.'/02/29'])->count();
        $marco = Correios::whereBetween('created_at',[$ano.'/03/01',$ano.'/03/31'])->count();
        $abril = Correios::whereBetween('created_at',[$ano.'/04/01',$ano.'/04/30'])->count();
        $maio = Correios::whereBetween('created_at',[$ano.'/05/01',$ano.'/05/31'])->count();
        $junho = Correios::whereBetween('created_at',[$ano.'/06/01',$ano.'/06/30'])->count();
        $julho = Correios::whereBetween('created_at',[$ano.'/07/01',$ano.'/07/31'])->count();
        $agosto = Correios::whereBetween('created_at',[$ano.'/08/01',$ano.'/08/31'])->count();
        $setembro = Correios::whereBetween('created_at',[$ano.'/09/01',$ano.'/09/30'])->count();
        $outubro = Correios::whereBetween('created_at',[$ano.'/10/01',$ano.'/10/31'])->count();
        $novembro = Correios::whereBetween('created_at',[$ano.'/11/01',$ano.'/11/30'])->count();
        $dezembro = Correios::whereBetween('created_at',[$ano.'/12/01',$ano.'/12/31'])->count();

        return view('estatistica')->with('meses',array(
            $janeiro,
            $fevereiro,
            $marco,
            $abril,
            $maio,
            $junho,
            $julho,
            $agosto,
            $setembro,
            $outubro,
            $novembro,
            $dezembro
        ));

    }

    public function pesquisa(Request $request){

        if (!empty($request->pesquisa_correio)  ){
            $id_correio = explode("-",$request->pesquisa_correio);
            $id_correio = str_replace(" ","", $id_correio[0]);
            $correios = Correios::findOrFail($id_correio);
            return redirect('/correios/detalhes/'.  $id_correio)->with('correios',$correios)->with('titulo','Pesquisa Correio');
        }else{
            $correios = Correios::orderBy('created_at','desc')->paginate(10);
            return view('correios/index')->with('correios',$correios)->with('titulo','Pesquisa Correio');
        }
        //return redirect('utilizadores/index')->with('utilizadores',$utilizadores);
    }

}