@extends('layouts.dashboard')
@section('page_heading','Serviços')
@section('section')

    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    @if (session('mensagem'))
        <div class="alert alert-success animated fadeIn">
            {{ session('mensagem') }}
            {{-- @include('widgets.alert', array('class'=>'success col-md-8', 'dismissable'=>true, 'message'=>  session('novo') , 'icon'=> 'check'))--}}
        </div>
    @endif

    <div class="row">
        <div class="col-md-7 col-md-offset-5">
            {!!  Form::open(array('url' => "/servicos/pesquisa", 'class' => 'navbar-form navbar-left', 'method' => 'GET')) !!}
            {!!  Form::text('pesquisa_servico',$value = null, array('placeholder' => 'Pesquisar', 'id' => 'pesquisa_servico', 'class' => 'form-control')) !!}
            {!!  Form::button('<i class="fa fa-search"></i>', array('class' => 'btn btn-default','type' => 'submit')) !!}
            {!!  Form::close() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <table class="table table-responsive table-striped ">
                <tr>
                    <th>ID</th>
                    <th>
                        Nome
                    </th>

                    <th>
                        <a href="#Modalinserir" type="button" data-toggle="modal" class="btn btn-default btn-sm pull-right"   >
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </th>
                </tr>

                @foreach($servicos as $servico)
                    <tr>
                        <td>{{ $servico->id }}</td>
                        <td>
                            {{ $servico->nome }}
                        </td>

                        <td>
                            <button type="button" class="btn btn-primary btn-outline btn-sm pull-right" style="margin-left: 5px;" data-toggle="modal"
                                    data-target="#Modalapagar" data-id="{{ $servico->id }}" data-nome="{{$servico->nome}}" >
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-success btn-outline btn-sm pull-right" data-toggle="modal"
                                    data-target="#Modaleditar" data-id="{{$servico->id}}" data-nome="{{$servico->nome}}" >
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pull-right">
                @if( count($servicos) > 1)
                    {{ $servicos->links() }}
                @endif
            </div>


        </div>
    </div>

    <div class="modal fade" id="Modalinserir" tabindex="-1" role="dialog" aria-labelledby="ModalinserirLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('/servicos/inserir') }}" method="POST"  >
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalapagarLabel">INSERIR SERVIÇO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <label for="nome" class="control-label">Nome</label>
                            </div>
                            <div class="col-md-6">
                                <input id="nome" class="form-control" type="text" name="nome" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Inserir</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modaleditar" tabindex="-1" role="dialog" aria-labelledby="ModaleditarLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('servicos/editar') }}" method="POST"  >
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModaleditarLabel">EDITAR SERVIÇO</h4>
                    </div>
                    <div class="modal-body">
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <label for="id" class="control-label">ID </label>
                            </div>
                            <div class="col-md-2">
                                <input id="id" class="form-control" type="text"  readonly="true" name="id" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <label for="nome" class="control-label">Nome </label>
                            </div>
                            <div class="col-md-6">
                                <input id="nome" class="form-control" type="text" name="nome"  >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modalapagar" tabindex="-1" role="dialog" aria-labelledby="ModalapagarLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('servicos/apagar') }}" method="post" >
                    {{--  {{ method_field('PATCH') }} {{ csrf_token() }}--}}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalapagarLabel">APAGAR SERVIÇO</h4>
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
                                <label for="nome" class="control-label">Nome </label>
                            </div>
                            <div class="col-md-6">
                                <input id="nome" readonly="true" class="form-control" type="text" name="nome" value="">
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

    <script src={{ asset("/js/jquery-ui.js") }}></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function () {
            $('input:text').bind({
            });
            $( "#pesquisa_servico" ).autocomplete({
                minLength:1,
                autoFocus: true,
                source: '{{URL('/servicos/getdataservico')}}'
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#Modaleditar').on('show.bs.modal', function (e) {
                console.log( "ready!modaleditar" );
                var id = $(e.relatedTarget).data('id'); // Button that triggered the modal
                var nome = $(e.relatedTarget).data('nome');
                var modal = $(this)
                //modal.find('.modal-title').text('EDITAR' + ' - ' + id)
                modal.find('.modal-body input[name=id]').val(id)
                modal.find('.modal-body input[name=nome]').val(nome);
            });

            $('#Modalapagar').on('show.bs.modal', function (e) {
                console.log( "ready!modalapagar" );
                var id = $(e.relatedTarget).data('id'); // Button that triggered the modal
                var nome = $(e.relatedTarget).data('nome');
                var modal = $(this)
                //modal.find('.modal-title').text('EDITAR' + ' - ' + id)
                modal.find('.modal-body input[name=id]').val(id)
                modal.find('.modal-body input[name=nome]').val(nome);
            });
        });
    </script>
@stop