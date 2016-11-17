@extends('layouts.dashboard')
@section('page_heading','Detalhes de Correio nr '.$correio->id)
@section('section')





    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#dados" aria-controls="dados" role="tab"  data-toggle="tab">Dados</a></li>
                <li role="presentation">
                    <a href="#movimentos" aria-controls="movimentos" role="tab" data-toggle="tab">Movimentos</a>
                </li>
            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="dados">


                        <div class="row form-group" style="margin-top:20px;">
                            <label for="id" class="col-md-3 col-md-offset-1 control-label">ID </label>
                            <div class="col-md-2">
                                <input id="id" type="text" class="form-control" readonly name="id"
                                       value="{{ $correio->id }}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="assunto" class="col-md-3  col-md-offset-1 control-label">Assunto </label>
                            <div class="col-md-6">
                                <input id="assunto" type="text" class="form-control" readonly name="assunto"
                                       value="{{ $correio->assunto }}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="observacoes" class="col-md-3  col-md-offset-1 control-label">Observações do Correio</label>
                            <div class="col-md-6">
                                <textarea id="observacoes" type="text" style="resize: none;" class="form-control" readonly name="observacoes">{{ $correio->observacoes }}</textarea>
                            </div>
                        </div>

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
        <div class="row">
            <button class="btn btn-info pull-right" >
                <a href="{{ url('/correios/index') }}"> <span class="glyphicon glyphicon-step-backward"></span> Voltar</a>
            </button>
            <button class="btn btn-success pull-right" style="margin-right: 10px;" >
                <a href="{{ url('/correios/reenvio/'.$correio->id) }}"> <span class="glyphicon glyphicon-refresh"></span> Reenviar</a>
            </button>
        </div>
    </div>

@stop