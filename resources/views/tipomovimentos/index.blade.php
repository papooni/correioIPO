@extends('layouts.dashboard')
@section('page_heading','Tipo de Movimentos')
@section('section')


    @if (session('mensagem'))
        <div class="alert alert-success">
            {{ session('mensagem') }}
        </div>
    @endif



    <div class="col-md-8 col-md-offset-2">
        <table class="table table-responsive table-striped ">
            <tr>
                <th>ID</th>
                <th>
                    Descrição
                </th>
                <th>
                    <a href="#Modalinserir" type="button" data-toggle="modal" class="btn btn-default btn-sm pull-right"   >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                </th>
            </tr>

            @foreach($tipo_movimentos as $tipo_movimentos)
                <tr>
                    <td>{{ $tipo_movimentos->id }}</td>
                    <td>{{ $tipo_movimentos->descricao }}</td>
                    <td>
                        <button  type="button" class="btn btn-primary btn-outline btn-sm pull-right" style="margin-left:5px;" data-toggle="modal"
                                 data-target="#Modalapagar" data-id="{{ $tipo_movimentos->id }}" data-descricao="{{$tipo_movimentos->descricao}}"    >
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success btn-outline btn-sm pull-right" data-toggle="modal"
                                data-target="#Modaleditar" data-id="{{$tipo_movimentos->id}}" data-descricao="{{$tipo_movimentos->descricao}}" >
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="modal fade" id="Modalinserir" tabindex="-1" role="dialog" aria-labelledby="ModalinserirLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" action="{{ url('tipo_movimentos/inserir') }}" method="POST"  >
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModalapagarLabel">INSERIR TIPO DE MOVIMENTO</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="descricao" class="control-label">Descrição</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="descricao" class="form-control" type="text" name="descricao" value="">
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
                    <form action="{{ url('tipo_movimentos/editar') }}" method="post">
                        {{ csrf_field() }}

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModaleditarLabel">EDITAR TIPO DE MOVIMENTO</h4>
                        </div>
                        <div class="modal-body">
                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="id" class="control-label">ID </label>
                                </div>
                                <div class="col-md-2">
                                    <input id="id" class="form-control" type="text" readonly="true" name="id" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="descricao" class="control-label">Descrição</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="descricao" class="form-control" type="text" name="descricao"  >
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
                    <form action="{{ url('tipo_movimentos/apagar') }}" method="get">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModalapagarLabel">APAGAR TIPO DE MOVIMENTO</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="id" class="control-label">ID </label>
                                </div>
                                <div class="col-md-2">
                                    <input id="id"  class="form-control" type="text" readonly="true" name="id" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="descricao" class="control-label">Descrição</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="descricao" readonly="true" class="form-control" type="text" name="descricao" value="">
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

    </div>

    {{--<script src="/correioIPO/public/js/jquery-1.12.4.js"></script>--}}
    <script src="{{ url('js/jquery-ui.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#Modaleditar').on('show.bs.modal', function (e) {
                console.log( "ready!modaleditar" );
                var id = $(e.relatedTarget).data('id'); // Button that triggered the modal
                var descricao = $(e.relatedTarget).data('descricao');
                var modal = $(this)
                //modal.find('.modal-title').text('EDITAR' + ' - ' + id)
                modal.find('.modal-body input[name=id]').val(id)
                modal.find('.modal-body input[name=descricao]').val(descricao);

            });


            $('#Modalapagar').on('show.bs.modal', function (e) {
                console.log( "ready!modalapagar" );
                var id = $(e.relatedTarget).data('id'); // Button that triggered the modal
                var descricao = $(e.relatedTarget).data('descricao');
                var modal = $(this)
                //modal.find('.modal-title').text('EDITAR' + ' - ' + id)
                modal.find('.modal-body input[name=id]').val(id)
                modal.find('.modal-body input[name=descricao]').val(descricao);
            });
        });
    </script>
@stop