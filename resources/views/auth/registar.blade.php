@extends('layouts.dashboard')
@section('page_heading','Registar Utilizador')
@section('section')

    @if (session('novo'))
        <div class="alert alert-success">
            {{ session('novo') }}
        </div>
    @endif


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/registar_utilizador') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome </label>


                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}">
                                @if ($errors->has('nome'))
                                {{--<span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>--}}
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                {{--<span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>--}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                {{--<span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>--}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                {{--<span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>--}}
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('nr_mecanografico') ? ' has-error' : '' }}">
                            <label for="nr_mecanografico" class="col-md-4 control-label">Nr. Mecanográfico</label>

                            <div class="col-md-2">
                                <input id="nr_mecanografico" type="number" pattern= "[0-9]"  class="form-control" name="nr_mecanografico">

                                @if ($errors->has('nr_mecanografico'))
                                {{--<span class="help-block">
                                <strong>{{ $errors->first('nrmecanografico') }}</strong>--}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="administrador" class="col-md-4 control-label">Administrador</label>
                            <div class="col-md-2">
                                <input name="administrador" id="administrador" type="checkbox" value="1" style="margin-top:10px;" >

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Registar Utilizador
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop
