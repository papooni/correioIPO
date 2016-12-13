@extends('documentacao.dashboard')
@section('page_heading','Documentação')
@section('section')

    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    @if (session('novo'))
        <div id="mensagem" class="alert alert-success col-md-6 col-md-offset-3 fadeInDown animated text-center option">
            {{ session('novo') }}
        </div>
    @endif



    <script src="{{ url('js/jquery-ui.js') }}"></script>
    <script>
        $(function() {
            setTimeout(function() {
                $("#mensagem").hide('blind', {}, 500)
            }, 5000);
        });
    </script>
@stop

