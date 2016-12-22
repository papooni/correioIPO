@extends('layouts.dashboard')
@section('page_heading','Pedir Nova Password')
@section('section')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="get" action="{{ url('pedir_nova_password') }}">
                        {{ csrf_field() }}
                        {{--<input type="hidden" name="token" value="{{ $token }}">--}}
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label">Password Antiga</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" value="{{ $old_password or old('old_password') }}">

                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                        {{--<strong>{{ $errors->first('old_password') }}</strong>--}}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="new_password" class="col-md-4 control-label">Nova Password</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password">

                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                            <label for="new_password_confirmation" class="col-md-4 control-label">Confirmar Nova Password</label>
                            <div class="col-md-6">
                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation">

                                @if ($errors->has('new_password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
