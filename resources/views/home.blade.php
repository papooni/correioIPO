@extends('layouts.dashboard')
@section('page_heading','Dashboard')
@section('section')

    @if (session('novo'))
        <div class="alert alert-success">
            {{ session('novo') }}
        </div>
    @endif


    <div class="col-sm-12">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading" style="cursor: pointer;" onclick="window.location='correios/index';">
                        <div class="row" >
                            <div class="col-xs-3">
                                <i class="fa fa-envelope fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    {{ App\Correios::all()->count() }}
                                </div>
                                <div>CORREIO</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <span class="pull-left"><a href="{{ url ('correios/index') }}">Ver Mais</a></span>
                        <span class="pull-right"><a href="{{ url ('correios/index') }}"><i class="fa fa-arrow-circle-right"></i></a></span>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="cursor: pointer;" onclick="window.location='utilizadores/index';">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    {{ App\User::where('ativo',1)->get()->count() }}
                                </div>
                                <div>UTILIZADORES</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"><a href="{{ url ('utilizadores') }}">Ver Mais</a></span>
                            <span class="pull-right"><a href="{{ url ('utilizadores') }}"><i class="fa fa-arrow-circle-right"></i></a></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading" style="cursor: pointer;" onclick="window.location='servicos/index';">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-server fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    {{ App\Servicos::all()->count() }}
                                </div>
                                <div>SERVIÇOS</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"><a href="{{ url ('servicos/index') }}">Ver Mais</a></span>
                            <span class="pull-right"><a href="{{ url ('servicos/index') }}"><i class="fa fa-arrow-circle-right"></i></a></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="cursor: pointer;" onclick="window.location='definicoes';">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-cogs fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">&nbsp</div>
                                <div>DEFINIÇÕES</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">
                                 <a href="{{ url ('definicoes') }}">Ver Mais</a>
                            </span>
                            <span class="pull-right">
                                 <a href="{{ url ('definicoes') }}">
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="cursor: pointer;" onclick="window.location='estatistica';">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-area-chart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">&nbsp</div>
                                <div>ESTATÍSTICAS</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">
                                <a href="{{ url ('estatistica') }}">Ver Mais</a>
                            </span>
                            <span class="pull-right">
                                <a href="{{ url ('estatistica') }}">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@stop

