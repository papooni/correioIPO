@extends('documentacao.docdashboard')
@section('page_heading','Documentação')
@section('section')


    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    @if (session('novo'))
        <div id="mensagem" class="alert alert-success col-md-6 col-md-offset-3 fadeInDown animated text-center option">
            {{ session('novo') }}
        </div>
    @endif


                <img class="img-responsive img-rounded" src="img/logo_ipo_cortado.png" width="70%" style="margin-left:-15px;">


    <script src="{{ url('js/jquery-ui.js') }}"></script>
    <script>
        $(function() {
            setTimeout(function() {
                $("#mensagem").hide('blind', {}, 500)
            }, 5000);
        });
    </script>
@stop