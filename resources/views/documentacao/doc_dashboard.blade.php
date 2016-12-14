@extends('layouts.plane')

@section('body')
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="navbar-brand" href="{{ url ('/home') }}">Gestão de Correio Interno | IPO</a>
                    <img class="navbar-brand" src="{{ url('img/ipo_logo_simple.png') }}" with="50" height="50">
                </div>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                            <a href="{{ url ('/home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li >
                            <a href="#"><i class="fa fa-envelope fa-fw"></i> Php Framework Laravel<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('correios/index') }}">Versão</a>
                                </li>
                                <li {{ (Request::is('*correios/registar') ? 'class="active"' : '') }}>
                                    <a href="{{ url ('correios/registar') }}">Componentes</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Manuais
                                <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Manual de Instalação</a>
                                </li>
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Manual de Utilização</a>
                                </li>
                            </ul>
                        </li>

                        <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url ('forms') }}"><i class="fa fa-cog fa-fw"></i> Base de Dados</a>
                        </li>
                        <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url ('forms') }}"><i class="fa fa-cog fa-fw"></i> Requisitos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Funcionais</a>
                                </li>
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Não Funcionais</a>
                                </li>
                            </ul>
                        </li>
                        <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url ('forms') }}"><i class="fa fa-cog fa-fw"></i> Papeis de Utilizadores<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Administrador</a>
                                </li>
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Normal</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>

        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1>@yield('page_heading')</h1>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                @yield('section')
            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop
