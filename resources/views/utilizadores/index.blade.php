@extends('layouts.dashboard')
@section('page_heading', $titulo)
@section('section')
    <link rel="stylesheet" href={{ asset("css/select2.css")}}>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    {{--@if (session('mensagem'))
        <div class="alert alert-success col-md-5 fadeInDown animated text-center" style="position: absolute;padding:10px;">
            {{ session('mensagem') }}
        </div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger col-md-3 col-md-offset-2 animated fadeInDown text-center" style="position: absolute; padding: 10px;">
            {{ session('erro') }}
        </div>
    @endif--}}

    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            {!!  Form::open(array('url' => "/utilizadores/pesquisa", 'class' => 'navbar-form navbar-left', 'method' => 'GET')) !!}
            {!!  Form::text('pesquisa_utilizador',$value = null, array('placeholder' => 'Pesquisar', 'id' => 'pesquisa_utilizador', 'class' => 'form-control')) !!}
            {!!  Form::button('<i class="fa fa-search"></i>', array('class' => 'btn btn-default','type' => 'submit')) !!}
            {!!  Form::close() !!}
        </div>
    </div>

    <div class="col-md-8 col-md-offset-2">
        <table class="table table-responsive table-striped ">
            <tr>
                {{-- <th>ID</th>--}}
                <th>
                    Nome
                </th>
                <th>
                    Email
                </th>
                <th>
                    Nr. Mecanográfico
                </th>
                <th></th>
            </tr>

            @foreach($utilizadores as $utilizador)
                <tr>
                    {{--  <td>{{ $utilizador->id }}</td>--}}
                    <td>
                        {{ $utilizador->nome }}
                    </td>
                    <td>
                        {{ $utilizador->email }}
                    </td>
                    <td>
                        {{ $utilizador->nr_mecanografico }}
                    </td>

                    <td>
                        <button class="btn btn-info btn-sm btn-outline vu" data-toggle="modal" data-target="#verUtilizador" data-toggle="tooltip" title="Ver Utilizador"   data-id="{{ $utilizador->id }}" data-nome="{{ $utilizador->nome }}" data-email="{{ $utilizador->email }}" data-nr="{{ $utilizador->nr_mecanografico }}"  style="margin-top:-5px;">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </button>
                        @if(Auth::user()->admin == 1)
                            <button class="btn btn-primary btn-sm btn-outline vu"  data-toggle="modal" data-target="#editarUtilizador" data-toggle="tooltip" title="Editar"   data-id="{{ $utilizador->id }}" data-nome="{{ $utilizador->nome }}" data-email="{{ $utilizador->email }}" data-nr="{{ $utilizador->nr_mecanografico }}" data-interno="{{ $utilizador->ativo}}"  style="margin-top:-5px;">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </button>
                            <button class="btn btn-success btn-sm btn-outline vu" data-toggle="modal" data-target="#apagarUtilizador" data-toggle="tooltip" title="Apagar"   data-id="{{ $utilizador->id }}" data-nome="{{ $utilizador->nome }}" data-email="{{ $utilizador->email }}" data-nr="{{ $utilizador->nr_mecanografico }}"  style="margin-top:-5px;">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                            <button class="btn btn-warning btn-sm btn-outline vu" data-toggle="modal" data-target="#atribuirServico" data-id="{{ $utilizador->id }}" data-toggle="tooltip" title="Atribuir Serviço"  style="margin-top:-5px;">
                                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                            </button>
                        @endif
                    </td>

                </tr>
            @endforeach
        </table>
        <div class="pull-right">
            @if( count($utilizadores) > 0)
                {{ $utilizadores->links() }}
            @endif
        </div>
    </div>

    <div class="modal fade verdadosservicos" id="verUtilizador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ver Utilizador</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-md-offset-2 col-md-8">
                        <ul class="nav nav-tabs" role="tablist">
                            <li id="li_dados" role="presentation" class="active">
                                <a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados</a>
                            </li>
                            <li id="li_servicos" role="presentation">
                                <a href="#servicos" aria-controls="servicos" role="tab" data-toggle="tab">Serviços</a>
                            </li>
                        </ul>
                        <div id="tabs" class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="dados">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label ">ID:</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="mid" name="mid" readonly value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label ">Nome:</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="mnome" name="mnome" readonly value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Email</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="memail" name="memail" readonly value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Nr Mecanografico:</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="mnr" name="mnr" readonly value="">
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane " id="servicos">
                                <table id="ver_servicos_utilizador"  class="table table-responsive table-striped ver_servicos_utilizador " style="margin-top:10px;">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOME</th>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn btn-success btn-sm btn-outline vu" title="Apagar" style="margin-top:-5px;display:none;">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-outline" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dadosservicos" id="editarUtilizador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('utilizadores/editar') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Editar Utilizador</h4>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-8 col-md-offset-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li id="li_dados2" role="presentation" class="active">
                                    <a href="#dados2" aria-controls="dados" role="tab" data-toggle="tab">Dados</a>
                                </li>
                                <li id="li_servicos2" role="presentation">
                                    <a href="#servicos2" aria-controls="servicos" role="tab" data-toggle="tab">Serviços</a>
                                </li>
                            </ul>
                            <div id="tabs" class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="dados2">
                                    <div class="form-group" style="margin-top:20px;">
                                        <label class="col-xs-4 control-label ">ID:</label>
                                        <div class="col-xs-5">
                                            <input type="text" class="form-control" id="mid" name="mid" readonly value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-4 control-label ">Nome:</label>
                                        <div class="col-xs-5">
                                            <input type="text" class="form-control" id="mnome" name="mnome" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label">Email</label>
                                        <div class="col-xs-5">
                                            <input type="text" class="form-control" id="memail" name="memail" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label">Nr Mecanografico:</label>
                                        <div class="col-xs-5">
                                            <input type="text" class="form-control" id="mnr" name="mnr" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="interno" class="col-md-4 control-label">Ativo </label>
                                        <div class="col-md-2">
                                            <input name="interno" id="interno" type="checkbox"  style="margin-top:10px;" >
                                        </div>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane " id="servicos2">

                                    <table id="servicos_utilizador" class="table table-responsive table-striped servicos_utilizador " style="margin-top:10px;">
                                        <tr>
                                            <th>ID</th>
                                            <th>NOME</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-dangger btn-sm btn-outline vu" title="Apagar" style="margin-top:-5px;">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="alert alert-success col-md-5 fadeInLeft animated text-center apagado" style="display:none;padding:10px;">
                                        Serviço Apagado!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group pull-right" style="margin-right:30px;">
                            <button type="submit" class="btn btn-info btn-outline" >Editar</button>
                            <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="apagarUtilizador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('utilizadores/apagar') }}" action="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Apagar Utilizador</h4>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-offset-2 col-md-10">
                            <div class="form-group">
                                <label class="col-xs-4 control-label ">Nome:</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" id="mnome" name="mnome" readonly value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Email</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" id="memail" name="memail" readonly value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Nr Mecanografico:</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" id="mnr" name="mnr" readonly value="">
                                </div>
                            </div>

                            <input type="hidden" class="form-control" id="mid" name="mid" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-outline" >Apagar</button>
                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="atribuirServico"  role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('utilizadores/atribuir_servico') }}" method="get">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Atribuir Serviço</h4>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-offset-2 col-md-10">
                            <div class="form-group{{ $errors->has('servico') ? ' has-error' : '' }}">
                                <label for="servico" class="col-md-4 control-label">Serviço</label>
                                <div class="col-md-4">
                                    <select id="servico" name="servico" style="width:200px;" class="select_servico_associado" >
                                        <option></option>
                                        {{--{{ $servicos = \App\Servicos::all() }}--}}
                                        {{ $servicos = \App\Servicos::all()}}
                                        @foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}" {!!  (old('servico')) == $servico->id ? "selected":"" !!}>{{ $servico->nome }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('servico'))
                                        {{--<span class="help-block">
                                            <strong>{{ $errors->first('servico_origem') }}</strong>
                                        </span>--}}
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" class="form-control" id="mid" name="mid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-outline" >Atribuir</button>
                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- dava conflito com o frontend.jspois o frontend.js é uma versao do jquery quitada
    <script src="/correioIPO/public/js/jquery-1.12.4.js"></script>
    --}}

    <script src="{{ url('js/jquery-ui.js') }}"></script>
    <script src={{ asset("/js/select2.full.js")}}></script>

    <script>
        $(document).on("click", ".vu", function () {
            var id = $(this).data('id');
            var nome = $(this).data('nome');
            var email = $(this).data('email');
            var nr = $(this).data('nr');
            var interno = $(this).data('interno');

            $(".modal-body #mid").val( id );
            $(".modal-body #mnome").val( nome );
            $(".modal-body #memail").val( email );
            $(".modal-body #interno")[0].checked = interno;
            //$(".modal-body #interno").prop('checked', interno) ;
            $(".modal-body #mnr").val( nr );
        });
        $(document).ready(function () {
            //PESQUISA
            $('input:text').bind({
            });

            $( "#pesquisa_utilizador" ).autocomplete({
                minLength:1,
                autoFocus: true,
                source: '{{URL('/utilizadores/getdatautilizador')}}',
            });

            $('[data-toggle="tooltip"]').tooltip();

            //insere os servicos do utlizador na tabela
            $('.verdadosservicos').on('shown.bs.modal', function(event){
                $("#servicos").removeClass("active");
                $("#dados").addClass("active");
                $("#li_servicos").removeClass("active");
                $("#li_dados").addClass("active");
                var user_id = $(".verdadosservicos #mid").val();
                $.get('{{ url('/utilizadores/servicos?id=') }}'+ user_id ,function (data) {
                    console.log(data);
                    $('.ver_servicos_utilizador').empty();
                    $('.ver_servicos_utilizador').append('<tr><th>ID</th><th>Nome</th></tr>');
                    $.each(data, function(index, subServicouser){
                        $('.ver_servicos_utilizador').append('<tr><td>' + subServicouser.id + '</td><td>' + subServicouser.nome + '</td></tr>');
                    })
                });
            });

            //insere os servicos do utlizador na tabela e o botao de apagar
            $('.dadosservicos').on('shown.bs.modal', function(event){
                $("#servicos2").removeClass("active");
                $("#dados2").addClass("active");
                $("#li_servicos2").removeClass("active");
                $("#li_dados2").addClass("active");
                var user_id = $(".dadosservicos #mid").val();
                $.get('{{ url('/utilizadores/servicos?id=') }}'+ user_id ,function (data) {
                    console.log(data);
                    $('.servicos_utilizador').empty();
                    $('.servicos_utilizador').append('<tr><th>ID</th><th>Nome</th><th></th></tr>');
                    $.each(data, function(index, subServicouser){
                        $('.servicos_utilizador').append("<tr id=" + subServicouser.id +"><td>" + subServicouser.id + '</td><td>' + subServicouser.nome +
                                "</td><td><a href='#' class='btn btn-danger btn-sm btn-outline apagar_servico' title='Apagar' data-id="+ subServicouser.id +" style='margin-top:-5px;'> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span> </a></td></tr>");
                    })
                });
            });

            $(document).on("click", ".apagar_servico", function () {
                var idservico = $(this).data('id');
                var iduser = $(".modal-body #mid").val();

                $.get('{{ url('/utilizadores/apagarservicoutilizador?idservico=') }}' + idservico + '&iduser=' + iduser ,function (data) {
                    console.log(data);
                });

                //alert('ID SERVICO ' + idservico +'ID USER ' + iduser);
                //remove linha da tabela
                $('#'+idservico).fadeTo(400,0,function() {
                    $(this).remove();
                });

                //mostra alerta a dizer que a linha foi apagada
                $(function() {
                    setTimeout(function() {
                        $('.apagado').css("display", "block");
                        $('.apagado').show();
                    } , 400);
                });

                //remove alerta com fade
                $(function() {
                    setTimeout(function() {
                        $(".apagado").hide('blind', {}, 900)
                    }, 5000);
                });
            });

            $(".select_servico_associado").select2({
                placeholder: "Escolha o Serviço:",
            });
        });




    </script>
@stop