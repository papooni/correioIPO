@extends('layouts.dashboard')
@section('page_heading','<i class="fa fa-cog"></i> Definições de ' . $user->nome)
@section('section')


    <div class=" col-md-offset-1 col-md-8">
        <form class="form-horizontal" role="form" action="{{ url('/utilizadores/gravar_definicoes') }}" method="get">
            {{ csrf_field() }}


            <div class="row">
                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                    <label for="nome" class="col-md-4 control-label">Nome </label>


                    <div class="col-md-6">
                        <input id="nome" type="text" class="form-control" name="nome" value="{{$user->nome}}">
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
                        <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                        @if ($errors->has('email'))
                        </span>
                        @endif
                    </div>
                </div>
               {{-- <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password">
                        @if ($errors->has('password'))
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="col-md-4 control-label">Confirmar Password</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                        </span>
                        @endif
                    </div>
                </div>--}}
                <div class="form-group{{ $errors->has('nr_mecanografico') ? ' has-error' : '' }}">
                    <label for="nr_mecanografico" class="col-md-4 control-label">Nr. Mecanográfico</label>
                    <div class="col-md-2">
                        <input id="nr_mecanografico" type="number" pattern= "[0-9]"  class="form-control" name="nr_mecanografico" value="{{$user->nr_mecanografico}}">
                        @if ($errors->has('nr_mecanografico'))
                        </span>
                        @endif
                    </div>
                </div>
            </div>

           <a href="{{ url('home')  }}" class="btn btn-default btn-outline  pull-right" >Voltar</a>
            <button type="submit" class="btn btn-info btn-outline  pull-right"  style="margin-left: 10px;" >Gravar</button>
        </form>
   </div>

@stop