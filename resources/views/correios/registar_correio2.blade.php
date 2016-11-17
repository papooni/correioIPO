@extends('layouts.dashboard')
@section('page_heading','Registar Correio V2')

@section('section')
    <link rel="stylesheet" href={{ asset("css/select2.css")}}>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/correios/gravar2') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('assunto') ? ' has-error' : '' }}">
                        <label for="assunto" class="col-md-4 control-label">Assunto </label>
                        <div class="col-md-6">
                            <input id="assunto" type="text" class="form-control" name="assunto"
                                   value="{{ old('assunto') }}">
                            @if ($errors->has('assunto'))
                                {{-- <span class="help-block">
                                       <strong>{{ $errors->first('assunto') }}</strong>
                                 </span>--}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('observacoes') ? ' has-error' : '' }}">
                        <label for="observacoes" class="col-md-4 control-label">Observações </label>
                        <div class="col-md-6">
                            <textarea id="observacoes" type="text" rows="4" class="form-control" style="resize:none;" name="observacoes"
                            >{{ old('observacoes') }}</textarea>
                            @if ($errors->has('observacoes'))
                                {{--<span class="help-block">
                                         <strong>{{ $errors->first('observacoes') }}</strong>
                                 </span>--}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tipomovimento') ? ' has-error' : '' }}">
                        <label for="tipomovimento" class="col-md-4 control-label">Tipo de Movimento </label>
                        <div class="col-md-3">
                            <select id="tipomovimento" class="form-control" name="tipomovimento">
                                <option value="">Escolha Tipo :</option>
                                @foreach($tipomovimento as $tipomovimentos)
                                    <option value="{{  $tipomovimentos->id }}" {!!  (old('tipomovimento')) == $tipomovimentos->id ? "selected":"" !!} >{{ $tipomovimentos->descricao }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tipomovimento'))
                                {{--<span class="help-block">
                                        <strong>{{ $errors->first('tipomovimento') }}</strong>
                                </span>--}}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-5">
                        {{-- <div id="origem" style="display:none;">--}}
                        <div id="origem" >

                            <div class="form-group{{ $errors->has('servico_origem') ? ' has-error' : '' }}">
                                <label for="servico_origem" class="col-md-4 control-label">Serviço Origem </label>
                                <div class="col-md-4">
                                    <select id="servico_origem" name="servico_origem" style="width:200px;" class="select_servico_origem">
                                        <option></option>
                                        @foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}" {!!  (old('servico_origem')) == $servico->id ? "selected":"" !!}>{{ $servico->nome }}</option>
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
                                <label for="colaborador_origem" class="col-md-4 control-label">Colaborador Origem </label>
                                <div class="col-md-4">
                                    <select id="colaborador_origem" class="select_colaborador_origem" style="width:200px;"  name="colaborador_origem"
                                            value="">
                                        {{--<option></option>--}}
                                        {{--@foreach($utilizadores as $utilizador)
                                            <option value="{{ $utilizador->id }}" {!!  (old('colaborador_origem')) == $utilizador->id ? "selected":"" !!}>{{ $utilizador->nome }}</option>
                                        @endforeach--}}
                                    </select>
                                    @if ($errors->has('colaborador_origem'))
                                        {{--<span class="help-block">
                                            <strong>{{ $errors->first('colaborador_origem') }}</strong>
                                        </span>--}}
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- <div id="destino" style="display:none;">--}}
                        <div id="destino">

                            <div class="form-group{{ $errors->has('servico_destino') ? ' has-error' : '' }}">
                                <label for="servico_destino" class="col-md-4 control-label">Serviço Destino </label>
                                <div class="col-md-4">
                                    <select id="servico_destino"  class="select_servico_destino" style="width:200px;"  name="servico_destino"
                                            value="{{ old('servico_destino') }}">
                                        <option></option>
                                        @foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}" {!!  (old('servico_destino')) == $servico->id ? "selected":"" !!}>{{ $servico->nome }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('servico_destino'))
                                        {{--<span class="help-block">
                                            <strong>{{ $errors->first('servico_destino') }}</strong>
                                        </span>--}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('colaborador_destino') ? ' has-error' : '' }}">
                                <label for="colaborador_destino" class="col-md-4 control-label">Colaborador Destino </label>
                                <div class="col-md-4">
                                    <select id="colaborador_destino" class="select_colaborador_destino" style="width:200px;" name="colaborador_destino"
                                            value="{{ old('colaborador_destino') }}">
                                        {{--<option></option>--}}
                                        {{--@foreach($utilizadores as $utilizador)
                                            <option value="{{ $utilizador->id }}"  {!!  (old('colaborador_destino')) == $utilizador->id ? "selected":"" !!}>{{ $utilizador->nome }}</option>
                                        @endforeach--}}
                                    </select>
                                    @if ($errors->has('colaborador_destino'))
                                        {{--<span class="help-block">
                                            <strong>{{ $errors->first('colaborador_destino') }}</strong>
                                        </span>--}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-btn fa-envelope"></i> Registar Correio
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--<script src="js/jquery-1.12.4.js"></script>--}}
    <script src={{ asset("/js/jquery-ui.js")}}></script>
    <script src={{ asset("/js/select2.full.js")}}></script>


    <script>

        $(document).ready(function () {

            $('#servico_origem').on('change',function(e){
                $.get('{{ url('/servicos/utilizadores?servico_id=') }}' + e.target.value ,function(data){
                    $('#colaborador_origem')
                            .empty();
                    //.selectpicker('refresh');
                    $.each(data, function(index, subUsers) {
                        $('#colaborador_origem').append('<option value="' + subUsers.id + '">'+ subUsers.nome  +' </option>')
                        //.selectpicker('refresh');
                    })
                })
            })

            $('#servico_destino').on('change',function(e){
                $.get('{{ url('/servicos/utilizadores?servico_id=') }}' + e.target.value ,function(data){
                    $('#colaborador_destino')
                            .empty();
                    // .selectpicker('refresh');
                    $.each(data, function(index, subUsers) {
                        $('#colaborador_destino')
                                .append('<option value="' + subUsers.id + '">'+ subUsers.nome  +' </option>');
                        //.selectpicker('refresh');
                    })
                })
            })

            $(".select_servico_origem").select2({
                placeholder: "Escolha o Serviço de Origem:",
                tags: true,
                allowClear: true
            });

            $(".select_servico_destino").select2({
                tags: true,
                placeholder: "Escolha o Serviço de Destino:",
                allowClear: true
            });

            $(".select_colaborador_origem").select2({
                tags: true,
                placeholder: "Escolha o Colaborador de Origem:",
                allowClear: true
            });

            $(".select_colaborador_destino").select2({
                tags: true,
                placeholder: "Escolha o Colaborador de Destino:",
                allowClear: true
            });
        });

    </script>

@stop