@extends('layouts.dashboard')
@section('page_heading','Definições')
@section('section')
    <div class="col-sm-12">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-md-offset-3">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <div class="row">
                            <a href="notificacoes">
                                <i class="fa fa-exclamation-triangle fa-5x" style="color: #99cb84;"></i>
                                <div>NOTIFICAÇÕES</div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <div class="row">
                            <a href="administradores">
                                <i class="fa fa-user-secret fa-5x" style="color: #2a88bd;"></i>
                                <div>PERMISSÕES</div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@stop