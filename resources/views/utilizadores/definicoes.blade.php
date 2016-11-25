@extends('layouts.dashboard')
@section('page_heading','<i class="fa fa-cog"></i> Definições de ' . $user->nome)
@section('section')

    <link rel="stylesheet" href={{ asset("css/select2.css")}}>
    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    @if (session('mensagem'))
        <div class="alert alert-success col-md-2 col-md-offset-4 fadeInDown animated text-center" style="position: absolute;padding:10px;">
            {{ session('mensagem') }}
        </div>
    @endif
    <div class=" col-md-offset-1 col-md-8">
        <form class="form-horizontal" role="form" action="{{ url('/utilizadores/gravar_definicoes') }}" method="get">
            {{ csrf_field() }}

            <div class="row">

                <div class="modal-body col-md-offset-2 col-md-10">
                    <ul class="nav nav-tabs" role="tablist">
                        <li id="li_dados" role="presentation" class="active">
                            <a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados</a>
                        </li>
                        @if (Auth::user()->admin)
                        <li id="li_servicos" role="presentation">
                            <a href="#servicos" aria-controls="servicos" role="tab" data-toggle="tab">Serviços</a>
                        </li>
                        @endif
                    </ul>
                    <div id="tabs" class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="dados">
                            <div style="margin-top: 10px;" class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                <label for="nome" class="col-md-4 control-label">Nome </label>
                                <div class="col-md-6">
                                    <input id="nome" type="text" class="form-control" name="nome" value="{{$user->nome}}">
                                    @if ($errors->has('nome'))
                                    {{--<span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>--}}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail </label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                                    @if ($errors->has('email'))
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('nr_mecanografico') ? ' has-error' : '' }}">
                                <label for="nr_mecanografico" class="col-md-4 control-label">Nr. Mecanográfico</label>
                                <div class="col-md-3">
                                    <input id="nr_mecanografico" type="number" pattern= "[0-9]"  class="form-control" name="nr_mecanografico" value="{{$user->nr_mecanografico}}">
                                    @if ($errors->has('nr_mecanografico'))
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (Auth::user()->admin)
                        <div role="tabpanel" class="tab-pane " id="servicos">
                            <table id="servicos_utilizador"  class="table table-responsive table-striped " style="margin-top:10px;">
                                <tr>
                                    <th>ID</th>
                                    <th>NOME</th>
                                    <th>
                                        <a href="#atribuirServico" type="button" data-toggle="modal" data-id="{{ $user->id }}" class="btn btn-default btn-sm pull-right vu"   >
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </a>
                                    </th>

                                </tr>

                                @foreach( $servicos as $servico)
                                    <tr>
                                        <td>{{ $servico->servicos_id }}</td>
                                        <td>{{ \App\Servicos::find($servico->servicos_id)->nome }}</td>
                                        <td>
                                            <a  href="#apagarServico" class="btn btn-danger btn-sm btn-outline va" data-toggle="modal" title="Apagar" data-idutilizadorservico="{{ $servico->id }}"  data-nomeservico="{{ \App\Servicos::find($servico->servicos_id)->nome }}" style="margin-top:-5px;">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <a href="{{ url('home')}}" class="btn btn-default btn-outline pull-right" style="margin-left: 10px;" >Voltar</a>
                <button type="submit" class="btn btn-info btn-outline  pull-right"  style="margin-left: 10px;" >Gravar</button>
            </div>
        </form>

        <div class="modal fade" id="atribuirServico"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <form class="form-horizontal" role="form" action="{{ url('utilizadores/atribuir_servico') }}" method="get">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Atribuir Serviço</h4>
                        </div>
                        <div class="modal-body col-md-offset-2 col-md-10">

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
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-outline" >Atribuir</button>
                            <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="apagarServico" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ url('/utilizadores/apagarservico') }}" method="get">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Apagar Serviço</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom: 30px;">
                                <label for="nomeservico" class="col-md-4 col-md-offset-1 control-label">Nome </label>
                                <div class="col-md-6">
                                    <input id="nomeservico" class="form-control" readonly type="text" name="nomeservico" >
                                    <input id="idutilizadorservico" readonly type="hidden" name="idutilizadorservico" >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="margin-left: 10px;">Fechar</button>
                            <button type="submit" class="btn btn-danger">Apagar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>







    </div>
    <script src="{{ url('js/jquery-ui.js') }}"></script>
    <script src={{ asset("/js/select2.full.js")}}></script>
    <script>
        $(document).ready(function () {
            $(document).on("click", ".vu", function () {
                var id = $(this).data('id');
                $(".modal-body #mid").val( id );
            });

            $(document).on("click", ".va", function () {
                var idutilizadorservico = $(this).data('idutilizadorservico');
                var nomeservico = $(this).data('nomeservico');

                $(".modal-body #idutilizadorservico").val( idutilizadorservico );
                $(".modal-body #nomeservico").val( nomeservico );
            });

            $(".select_servico_associado").select2({
                placeholder: "Escolha o Serviço:",
            });
        });
    </script>
@stop