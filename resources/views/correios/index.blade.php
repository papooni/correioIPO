@extends('layouts.dashboard')
@section('page_heading','Correio')
@section('section')
    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    {{--@if (session('mensagem'))
        <div class="alert alert-success col-md-5 col-md-offset-2 fadeInDown animated text-center">
            {{ session('mensagem') }}
        </div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger col-md-3 col-md-offset-2 animated fadeInDown text-center" style="position: absolute; padding: 10px;">
            {{ session('erro') }}
        </div>
    @endif
--}}
    <div class="row">
        <div class="col-md-4 pull-right">
            {!!  Form::open(array('url' => "/correios/pesquisa", 'class' => 'navbar-form navbar-left', 'method' => 'GET')) !!}
            {!!  Form::text('pesquisa_correio',$value = null, array('placeholder' => 'Pesquisar', 'id' => 'pesquisa_correio', 'class' => 'form-control')) !!}
            {!!  Form::button('<i class="fa fa-search"></i>', array('class' => 'btn btn-default','type' => 'submit')) !!}
            {!!  Form::close() !!}
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            @if (count($correios) === 0)
                <div class="col-md-offset-2">
                    <h2>De momento não existe Correio Registado! </h2>
                </div>
            @else
                <table class="table table-responsive table-striped table-hover" style="margin-top:10px;">
                    <tr>
                        <th>ID</th>
                        <th>Assunto</th>
                        <th>Observações</th>
                        <th>Data</th>
                        {{--<th>Movimento</th>--}}
                        <th></th>
                    </tr>

                    @foreach($correios as $correio)
                        @foreach ($correio->movimentos as $cc)
                            @if(count(Auth::user()->utilizadorservicos->where('servicos_id',$cc->servico_origem)) > 0 || count(Auth::user()->utilizadorservicos->where('servicos_id',$cc->servico_destino)) > 0)
                                <?php $correioassociado = 1;  ?>
                            @else
                                <?php $correioassociado = 0;  ?>
                            @endif
                        @endforeach
                        @if ($correioassociado == 1)
                            {{--  <h4>Existem movimentos deste correio {{ $correio->id }} associados ao servico do utilizador</h4>--}}
                            @if( $correio->movimentos->first()->lido == 0)
                                <tr style="font-weight: bold">
                            @else
                                <tr style="font-weight: normal">
                                    @endif
                                    <td>{{ $correio->id }}</td>
                                    <td>{{ $correio->assunto }}</td>
                                    <td>{{ $correio->observacoes }}</td>
                                    <td>{{ $correio->created_at }}</td>
                                    <td>
                                        @if (Auth::user()->admin)
                                            <a href="{{ url('/correios/apagar/'.  $correio->id) }}"
                                               style="margin-left:5px;" class="btn btn-sm btn-danger btn-outline pull-right tool"  data-toggle="modal"
                                               data-target="#Modalapagar" data-id="{{ $correio->id }}" data-assunto="{{$correio->assunto}}" data-observacoes="{{ $correio->observacoes }}"  title="Apagar Correio!">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        @endif
                                        <a href="{{ url('/correios/reenvio/'.  $correio->id ) }}"
                                           class="btn btn-sm btn-success btn-outline pull-right tool"  title="Reenviar!">
                                            <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ url('/correios/detalhes/'.  $correio->id) }}"
                                           style="margin-right:5px;" class="btn btn-sm btn-info btn-outline pull-right tool" title="Ver Correio!">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            {{--@if(count(Auth::user()->utilizadorservicos->where('servicos_id',$correio->movimentos->first()->servico_origem)) > 0 || count(Auth::user()->utilizadorservicos->where('servicos_id',$correio->movimentos->first()->servico_destino)) > 0)
                                <tr><h3>Correio {{ $correio->id }} está associado aos sserviços do utilizador</h3><hr></tr>
                                @else
                                <tr><h3>Correio {{ $correio->id }} não está associado aos serviços do utilizador.</h3><hr></tr>
                            @endif--}}
                            @endforeach

                    {{--@foreach($correios as $correio)
                        --}}{{--@if ($correio->lido == 0)--}}{{--
                        @if( $correio->movimentos->first()->lido == 0)
                            <tr style="font-weight: bold">
                        @else
                            <tr style="font-weight: normal">
                                @endif
                                <td>{{ $correio->id }}</td>
                                <td>{{ $correio->assunto }}</td>
                                <td>{{ $correio->observacoes }}</td>
                                <td>{{ $correio->created_at }}</td>
                                --}}{{-- <td>{{$correio}}</td>
                                 <td>{{ $correio->movimentos }}</td>
                                 <td>{{ $correio->tipomovimentos_id }}</td>--}}{{--
                                --}}{{--<td>{{ $correio->movimentos->tipomovimento  }}</td>--}}{{--
                                --}}{{--<td>{{ $correio->tipomovimento($correio->tipomovimentos_id) }}</td>--}}{{--
                                <td>
                                    @if (Auth::user()->admin)
                                        <a href="{{ url('/correios/apagar/'.  $correio->id) }}"
                                           style="margin-left:5px;" class="btn btn-sm btn-danger btn-outline pull-right tool"  data-toggle="modal"
                                           data-target="#Modalapagar" data-id="{{ $correio->id }}" data-assunto="{{$correio->assunto}}" data-observacoes="{{ $correio->observacoes }}"  title="Apagar Correio!">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a>
                                    @endif
                                    <a href="{{ url('/correios/reenvio/'.  $correio->id ) }}"
                                       class="btn btn-sm btn-success btn-outline pull-right tool"  title="Reenviar!">
                                        <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ url('/correios/detalhes/'.  $correio->id) }}"
                                       style="margin-right:5px;" class="btn btn-sm btn-info btn-outline pull-right tool" title="Ver Correio!">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach--}}
                </table>
                <div class="pull-right">
                    @if( count($correios) >= 1)
                        {{ $correios->links() }}
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="Modalapagar" tabindex="-1" role="dialog" aria-labelledby="ModalapagarLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('correios/apagar') }}" method="post" >
                    {{--  {{ method_field('PATCH') }} {{ csrf_token() }}--}}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalapagarLabel">APAGAR CORREIO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <label for="id" class="control-label">ID </label>
                            </div>
                            <div class="col-md-2">
                                <input id="id"  class="form-control" type="text" readonly="true" name="id" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3  col-md-offset-2">
                                <label for="assunto" class="control-label">Assunto </label>
                            </div>
                            <div class="col-md-6">
                                <input id="assunto" readonly="true" class="form-control" type="text" name="assunto" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3  col-md-offset-2">
                                <label for="observacoes" class="control-label">Observacoes </label>
                            </div>
                            <div class="col-md-6">
                                <input id="observacoes" readonly="true" class="form-control" type="text" name="observacoes" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Apagar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ url('js/jquery-ui.js') }}"></script>

    <script>
        $(document).ready(function () {
            //PESQUISA
            $('input:text').bind({
            });
            $( "#pesquisa_correio" ).autocomplete({
                minLength:1,
                autoFocus: true,
                source: '{{URL('/correios/getdatacorreio')}}',
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.tool').tooltip();
            $('#Modalapagar').on('show.bs.modal', function (e) {
                console.log( "ready!modalapagar" );
                var id = $(e.relatedTarget).data('id'); // Button that triggered the modal
                var assunto = $(e.relatedTarget).data('assunto');
                var observacoes = $(e.relatedTarget).data('observacoes');

                var modal = $(this)
                //modal.find('.modal-title').text('EDITAR' + ' - ' + id)
                modal.find('.modal-body input[name=id]').val(id)
                modal.find('.modal-body input[name=assunto]').val(assunto);
                modal.find('.modal-body input[name=observacoes]').val(observacoes);

            });
        });
    </script>
@stop