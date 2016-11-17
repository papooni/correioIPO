@extends('layouts.dashboard')
@section('page_heading','Administradores')
@section('section')

    <link href="assets/stylesheets/bootstrap-switch.css" rel="stylesheet">
    @if (session('mensagem'))
        <div class="alert alert-success">
            {{ session('mensagem') }}
        </div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger">
            {{ session('erro') }}
        </div>
    @endif
    <div class="row">
        <div class=" teste-tab-container">
            <div class="col-md-offset-2 col-lg-3 col-md-3 col-sm-3 col-xs-3 teste">
                <div class="list-group">
                    @foreach($users as $user)
                        <a class="list-group-item" href="#">{{$user->nome}}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 tab-content teste-tab">
                <!-- flight section -->
                @foreach($users as $user)
                    <div class="tab-pane">
                        <center>
                            <h4>ADMINISTRADOR</h4>
                            <h5>
                                @if($user->admin)
                                    <input type="checkbox" id="administrador" name="administrador" checked data-id="{{ $user->id }}">
                                @else
                                    <input type="checkbox" id="administrador" name="administrador"  data-id="{{ $user->id }}">
                                @endif
                            </h5>
                        </center>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade modal-administra" id="alerta" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Permissão Administrador Alteradas</h4>
                </div>
                <div class="modal-body text-center">
                    <p style="align-content: center">As permissões foram alteradas!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <script src="assets/scripts/bootstrap-switch.js"></script>
    <script>
        $(document).ready(function() {
            $("div.teste>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.teste-tab>div.tab-pane").removeClass("active");
                $("div.teste-tab>div.tab-pane").eq(index).addClass("active");
            });


            $('input[name="administrador"]').on('switchChange.bootstrapSwitch', function(event, state) {
                var id = $(this).data('id');
                $.get('{{ url('/utilizadores/administradores?id=') }}'+ id+ '&estado=' + state ,function (data) {
                    console.log(data + state);
                    $('#alerta').modal('show');
                });

            });





        });
        $(function(argument) {
            $('[type="checkbox"]').bootstrapSwitch();
        })
    </script>
@stop