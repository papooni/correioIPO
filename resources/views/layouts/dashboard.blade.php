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

            <ul class="nav navbar-nav navbar-right" style="margin-right: 0;">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('login') }}">Entrar</a></li>
                    {{-- <li><a href="{{ url('registar') }}">Registar</a></li>--}}
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->nome }}
                            @if (  Auth::user()->correioNaoLido()->count() > 0)
                                <span style="background-color:red;margin-left:10px;margin-right: 10px;" class="badge">
                                    {{  Auth::user()->correioNaoLido()->count()  }}
                                    </span>
                            @else
                                <span style="margin-left:10px;margin-right: 10px;" class="badge">
                                        0
                                    </span>
                            @endif
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            {{-- @if(Auth::user()->admin >0)
                                 <li><a href="{{ url('/registar') }}"><i class="fa fa-btn fa-user"></i> Registar</a></li>
                             @endif--}}
                            <li><a href="{{ url('/utilizadores/definicoes/'.Auth::user()->id) }}">
                                    <i class="fa fa-cog"></i> Definições</a></li>
                            @if (  Auth::user()->correioNaoLido()->count() > 0)
                                <li><a href="{{ url('/correios/meu_correio') }}">
                                        <i class="fa fa-envelope" style="color:lightcoral;"></i> Meu Correio</a></li>
                            @else
                                <li><a href="{{ url('/correios/meu_correio') }}">
                                        <i class="fa fa-envelope"></i> Meu Correio</a></li>
                            @endif
                            <li><a href="{{ url('/docs2') }}"><i class="fa fa-btn fa-book"></i> Documentação</a></li>
                            <li><a href="{{ url('/reset_password') }}"><i class="fa fa-btn fa-unlock-alt"></i> Nova Password</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Sair</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        {{--<li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Procura...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>--}}
                        <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                            <a href="{{ url ('/home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li >
                            <a href="#"><i class="fa fa-envelope fa-fw"></i> Correio<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('correios/index') }}">Ver Correio</a>
                                </li>
                                {{-- <li {{ (Request::is('*allmail') ? 'class="active"' : '') }}>
                                     <a href="{{ url ('allmail') }}">Ver Correio</a>
                                 </li>--}}
                                <li {{ (Request::is('*correios/registar') ? 'class="active"' : '') }}>
                                    <a href="{{ url ('correios/registar') }}">Registar Correio</a>
                                </li>
                                {{--<li {{ (Request::is('*mailout') ? 'class="active"' : '') }}>
                                    <a href="{{ url ('mailout' ) }}">Registar Saída</a>
                                </li>--}}

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Utilizadores<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('utilizadores') }}">Ver Utilizadores</a>
                                </li>
                                @if(Auth::user()->admin >0)
                                    <li>
                                        <a href="{{ url ('/utilizadores/extra') }}">Ver Utilizadores Externos</a>
                                    </li>
                                    <li>
                                        <a href="{{ url ('/registar') }}">Adicionar Utilizadores</a>
                                    </li>
                                    {{-- <li>
                                         <a href="{{ url ('/atribuirservicos') }}">Atribuir Serviços</a>
                                     </li>--}}
                                @endif
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li {{ (Request::is('*servicos/index') ? 'class="active"' : '') }}>
                            <a href="{{ url ('servicos/index') }}"><i class="fa fa-files-o fa-fw"></i> Serviços</a>
                        </li>

                        <li {{ (Request::is('*estatistica') ? 'class="active"' : '') }}>
                            <a href="{{ url ('estatistica') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Estatística
                                {{--<span class="fa arrow"></span>--}}</a>
                            <!-- /.nav-second-level -->
                            {{--<ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('#') }}">Por Mês</a></li>
                                <li><a href="{{ url ('#') }}">Por Serviço</a></li>
                                <li><a href="{{ url ('#') }}">Por Utilizador</a></li>
                            </ul>--}}
                        </li>
                        @if(Auth::user()->admin >0)
                            <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                                <a href="{{ url ('forms') }}"><i class="fa fa-cog fa-fw"></i> Definições<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ url ('tipo_movimentos') }}">Tipo de Movimento</a>
                                    </li>

                                    <li>
                                        <a href="{{ url ('notificacoes') }}">Notificações</a>
                                    </li>
                                    <li>
                                        <a href="{{ url ('administradores') }}">Administradores</a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                        <div class="page-header">
                            <h1>@yield('page_heading')</h1>

                        @if (session('novo'))
                            <div id="mensagem" class="alert alert-success col-md-5 col-md-offset-3 fadeInUp animated text-center option" style="position: absolute;padding:10px;margin-top: -50px;">
                                {{ session('novo') }}
                            </div>
                        @endif

                        @if (session('mensagem'))
                            <div id="mensagem" class="alert alert-success col-md-5 col-md-offset-3 fadeInUp animated text-center" style="position: absolute;padding:10px;margin-top: -50px;">
                                {{ session('mensagem') }}
                            </div>
                        @endif

                        @if (session('erro'))
                            <div class="alert alert-danger col-md-5 col-md-offset-5 animated fadeInUp text-center" style="position: absolute; padding: 10px;margin-top: -50px;">
                                {{ session('erro') }}
                            </div>
                        @endif
                        </div>
                        @yield('section')
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /#page-wrapper -->
        </div>
    </div>

    <script src="{{ url('js/jquery-ui.js') }}"></script>
    <script>
        $(function() {
            setTimeout(function() {
                $("#mensagem").hide('blind', {}, 500)
            }, 5000);
        });

        $(function() {
            setTimeout(function() {
                $("#novo").hide('blind', {}, 500)
            }, 5000);
        });


    </script>
@stop
