@extends('layouts.dashboard')
@section('page_heading','Reenvio de Correio nr '.$correio->id)
@section('section')


    <link rel="stylesheet" href={{ asset("css/bootstrap-select-1.css")}}>



    <div class="col-md-12">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados</a></li>
                <li role="presentation">
                    <a href="#movimentos" aria-controls="movimentos" role="tab" data-toggle="tab">Movimentos</a>
                </li>
            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="dados">
                    <form class="form-horizontal" role="form" method="POST" action='{{ url('/correios/reenvio_correio/'. $correio->id ) }}'>
                        {{ csrf_field() }}



                        <div class="row form-group" style="margin-top:20px;">
                            <label for="id" class="col-md-3 col-md-offset-1 control-label">ID </label>
                            <div class="col-md-2">
                                <input id="id" type="text" class="form-control" readonly name="id"
                                       value="{{$correio->id}}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="assunto" class="col-md-3  col-md-offset-1 control-label">Assunto </label>
                            <div class="col-md-6">
                                <input id="assunto" type="text" class="form-control" readonly name="assunto"
                                       value="{{$correio->assunto}}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="observacoes" class="col-md-3  col-md-offset-1 control-label">Observações do
                                Correio</label>
                            <div class="col-md-6">
                                <textarea id="observacoes" type="text" style="resize: none;" class="form-control"
                                          readonly name="observacoes">{{$correio->observacoes}}</textarea>
                            </div>
                        </div>



                        <div class="col-md-5">


                            <div class="form-group{{ $errors->has('servico_origem') ? ' has-error' : '' }}">
                                <label for="servico_origem" class="col-md-4  col-md-offset-1 control-label">Serviço
                                    Origem </label>
                                <div class="col-md-5">
                                    <select id="servico_origem" class="selectpicker" data-live-search="true" name="servico_origem" value="{{ old('servico_origem') }}">
                                        <option value="">Escolha o Serviço:</option>
                                        {@foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}">{{ $servico->nome }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('servico_origem'))
                                        {{--<span class="help-block">
                                            <strong>{{ $errors->first('servico_origem') }}</strong>
                                        </span>--}}
                                    @endif
                                </div>
                            </div>



                            <div class="form-group{{ $errors->has('colaborador_origem') ? ' has-error' : '' }}">
                                <label for="colaborador_origem" class="col-md-4  col-md-offset-1 control-label">Colaborador
                                    Origem </label>
                                <div class="col-md-5">
                                    <select id="colaborador_origem" class="selectpicker" data-live-search="true" name="colaborador_origem" value="{{ old('colaborador_origem') }}">
                                        <option value="{{ old('colaborador_origem') }}">Escolha o Colaborador:</option>
                                        {{--@foreach($utilizadores as $utilizador)
                                            <option value="{{ $utilizador->id }}">{{ $utilizador->nome }}</option>
                                        @endforeach--}}
                                    </select>
                                    @if ($errors->has('colaborador_origem'))
                                        {{-- <span class="help-block">
                                             <strong>{{ $errors->first('colaborador_origem') }}</strong>
                                         </span>--}}
                                    @endif
                                </div>
                            </div>


                        </div>

                        <div class="col-md-5">

                            <div class="form-group{{ $errors->has('servico_destino') ? ' has-error' : '' }}">
                                <label for="servico_destino" class="col-md-4  control-label">Serviço
                                    Destino </label>
                                <div class="col-md-5  col-md-offset-1">
                                    <select id="servico_destino" class="selectpicker" data-live-search="true" name="servico_destino" value="{{ old('servico_destino') }}">
                                        <option value="">Escolha o Serviço:</option>
                                        @foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}">{{ $servico->nome }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('servico_destino'))
                                        {{-- <span class="help-block">
                                             <strong>{{ $errors->first('servico_destino') }}</strong>
                                         </span>--}}
                                    @endif
                                </div>
                            </div>



                            <div class="form-group{{ $errors->has('colaborador_destino') ? ' has-error' : '' }}">
                                <label for="colaborador_destino" class="col-md-4 control-label">Colaborador
                                    Destino </label>
                                <div class="col-md-5  col-md-offset-1">
                                    <select id="colaborador_destino" class="selectpicker" data-live-search="true"
                                            name="colaborador_destino" value="{{ old('colaborador_destino') }}">
                                        <option value="">Escolha o Colaborador:</option>
                                        {{--{@foreach($utilizadores as $utilizador)
                                            <option value="{{ $utilizador->id }}">{{ $utilizador->nome }}</option>
                                        @endforeach--}}
                                    </select>
                                    @if ($errors->has('colaborador_destino'))
                                        {{-- <span class="help-block">
                                             <strong>{{ $errors->first('colaborador_destino') }}</strong>
                                         </span>--}}
                                    @endif
                                </div>

                            </div>


                        </div>

                        @if ( $tipo == '1')

                            <div class="row form-group">
                                <label for="tipomovimento" class="col-md-3 col-md-offset-1 control-label">Tipo de
                                    Movimento </label>
                                <div class="col-md-3">
                                    <input readonly id="tipomovimento" name="tipomovimento" class="form-control"
                                           value="Saída">
                                </div>
                            </div>

                        @endif
                        @if ( $tipo == '2')
                            <div class="row  form-group">
                                <label for="tipomovimento" class="col-md-3 col-md-offset-1 control-label">Tipo de
                                    Movimento </label>

                                <div class="col-md-3">
                                    <input readonly id="tipomovimento" name="tipomovimento" class="form-control"
                                           value="Entrada">
                                </div>
                            </div>

                        @endif

                        <div class="row form-group">
                            <label for="observacoes" class="col-md-3  col-md-offset-1 control-label">Observações do
                                Movimento</label>
                            <div class="col-md-6">
                                <textarea id="observacoes" type="text" style="resize: none;" class="form-control"
                                          name="observacoes"></textarea>
                            </div>
                        </div>

                        <div class="row form-group col-md-10">
                            <button class="btn btn-info pull-right" >
                                <a href="{{ url('/correios/index') }}">
                                    <span class="glyphicon glyphicon-step-backward"></span> Voltar</a>
                            </button>
                            <button type="submit" style="margin-right: 10px;" class="btn btn-success pull-right">
                                <span class="glyphicon glyphicon-share-alt"></span> Reenviar
                            </button>

                        </div>

                    </form>

                </div>

                <div role="tabpanel" class="tab-pane" id="movimentos">

                    <div class="row col-md-12  ">
                        <table class="table table-responsive table-condensed table-bordered table-hover" style="margin-top:10px;">
                            <tr>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">OBSERVAÇÕES</th>
                                <td colspan="2" style="text-align: center;font-weight: bold;">ORIGEM</td>
                                <td colspan="2" style="text-align: center;font-weight: bold;">DESTINO</td>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">DATA</th>
                            </tr>
                            <tr style="text-align: center;">

                                <th style="text-align: center;">Colaborador</th>
                                <th style="text-align: center;">Serviço</th>
                                <th style="text-align: center;">Colaborador</th>
                                <th style="text-align: center;">Serviço</th>

                            </tr>
                            @foreach($movimentos as $movimento)
                                <tr>
                                    <td>{{ $movimento->observacoes }}</td>
                                    <td>{{ $movimento->getNomeUtilizador($movimento->colaborador_origem) }}</td>
                                    <td>{{ $movimento->getNomeServico( $movimento->servico_origem) }}</td>
                                    <td>{{ $movimento-> getNomeUtilizador($movimento->colaborador_destino) }}</td>
                                    <td>{{ $movimento-> getNomeServico($movimento->servico_destino) }}</td>
                                    <td>{{ $movimento-> created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>


    <script src={{ asset("/js/bootstrap-select.js")}}></script>

    <script>
        $(document).ready(function () {
            $('#servico_origem').on('change',function(e){
                $.get('{{ url('/servicos/utilizadores?servico_id=') }}' + e.target.value ,function(data){
                    $('#colaborador_origem').empty();
                    $.each(data, function(index, subUsers) {
                        $('#colaborador_origem').append('<option value="' + subUsers.id + '">'+ subUsers.nome  +' </option>')
                                .selectpicker('refresh');
                    })
                })

            })

            $('#servico_destino').on('change',function(e){
                $.get('{{ url('/servicos/utilizadores?servico_id=') }}' + e.target.value ,function(data){
                    $('#colaborador_destino').empty();
                    $.each(data, function(index, subUsers) {
                        $('#colaborador_destino').append('<option value="' + subUsers.id + '">'+ subUsers.nome  +' </option>')
                                .selectpicker('refresh');
                    })
                })

            })
        });
    </script>

@stop