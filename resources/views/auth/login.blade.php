<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>IPO</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link rel="shortcut icon" href="http://ipoporto.pt/wp-content/themes/IPO/ipoporto_ficon.png" />
    <link rel="stylesheet" href="css/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Pathway+Gothic+One" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <style>
        html, body {
            height: 100%;
            width: 100%;
        }

        html {
            display: table;
            margin: auto;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: Pathway Gothic One;
            display: table-cell;
            vertical-align: middle;
        }

        .container {
            text-align: center;

        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 90px;
        }
        a {
            text-decoration: none;
            color:black;
        }
        a:hover{
            text-decoration: none;
            color:black;
        }

    </style>
</head>
<body>


<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <img src=" {{ asset("img/logo_ipo_cortado.png")  }}" class="animated fadeIn" style="position: absolute;top: -170px;left: 10px;" width="850" height="650">
    </div>
    <div class="col-md-4 col-sm-6 col-sm-offset-5 col-xs-6">
        {{--<img src=" {{ asset("img/logo_horizontal_ipo.png")  }}" width="230px" height="70px" >--}}
        <div class="panel panel-default" style="border: rgba(196, 196, 196,0.37) solid 1px;border-radius: 10px; -webkit-box-shadow: 0px 0 50px #ccc;">
            <div class="panel-heading" style="font-size: 20px;font-weight: bold;"> Entrar

            </div>
            <div class="panel-body" >
                <form class="form-horizontal" role="form" method="GET" action="{{ url('/entrar') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('nr_mecanografico') ? ' has-error' : '' }}">
                        <label for="nr_mecanografico" class="col-md-4 control-label">Utilizador</label>

                        <div class="col-md-6 input-group">

                                 <span class="input-group-addon" id="basic-addon1">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                            <input id="nr_mecanografico" type="text" class="form-control" name="nr_mecanografico" value="{{ old('nr_mecanografico') }}">

                            @if ($errors->has('nr_mecanografico'))
                                {{--<span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>--}}
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <div class="col-md-6 input-group">
                                 <span class="input-group-addon" id="basic-addon1">
                                <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                </span>
                            <input id="password" type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                {{--<span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>--}}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ligacao" class="col-md-4 control-label">Autenticação</label>
                        <div class="col-md-6">
                            <select id="ligacao" name="ligacao" class="form-control">
                                <option value="0">Normal</option>
                                <option value="1">Active Directory</option>
                                <option value="2">SSO</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <a class="btn btn-link" href="{{ url('/password/email') }}">Esqueceu a Password?</a>
                        </div>
                        <div class="row">
                            @if (session('mensagem'))
                                <div class="col-md-6 col-md-offset-3 alert alert-danger" style="padding: 6px;text-align: center;">
                                    {{ session('mensagem') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 col-md-offset-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Entrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>--}}
</body>
</html>



