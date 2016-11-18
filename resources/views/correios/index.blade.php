@extends('layouts.dashboard')
@section('page_heading','Correios')
@section('section')

    @if (session('mensagem'))
        <div class="alert alert-success">
            {{ session('mensagem') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 pull-right">
            {!!  Form::open(array('url' => "/correio/procura", 'class' => 'navbar-form navbar-left', 'method' => 'GET')) !!}
            {!!  Form::text('pesquisa_correio',$value = null, array('placeholder' => 'Pesquisar', 'id' => 'pesquisa_correio', 'class' => 'form-control')) !!}
            {!!  Form::button('<i class="fa fa-search"></i>', array('class' => 'btn btn-default','type' => 'submit')) !!}
            {!!  Form::close() !!}
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <div class="row">

            @if (count($correios) === 0)

                <div class="col-md-offset-2">
                    <h2>De momento não existe Correio Registado! </h2>
                </div>
            @else
                <table class="table table-responsive table-striped table-hover" style="margin-top:10px;">
                    <tr>
                        <th>ID</th>
                        <th>Assunto</th>
                        <th>Observações</th>
                        <th>Data</th>
                        {{--<th>Movimento</th>--}}

                        <th></th>
                    </tr>

                    @foreach($correios as $correio)
                        {{--@if ($correio->lido == 0)--}}
                        @if( $correio->movimentos->first()->lido == 0)
                        <tr style="font-weight: bold">
                        @else
                            <tr style="font-weight: normal">
                        @endif
                                <td>{{ $correio->id }}</td>
                                <td>{{ $correio->assunto }}</td>
                                <td>{{ $correio->observacoes }}</td>
                                <td>{{ $correio->created_at }}</td>
                               {{-- <td>{{$correio}}</td>
                                <td>{{ $correio->movimentos }}</td>
                                <td>{{ $correio->tipomovimentos_id }}</td>--}}
                                {{--<td>{{ $correio->movimentos->tipomovimento  }}</td>--}}
                               {{--<td>{{ $correio->tipomovimento($correio->tipomovimentos_id) }}</td>--}}
                                <td>
                                    <a href="{{ url('/correios/reenvio/'.  $correio->id ) }}"
                                       class="btn btn-sm btn-success btn-outline pull-right" data-toggle="tooltip" data-placement="top" title="Reenviar!">
                                        <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ url('/correios/detalhes/'.  $correio->id) }}"
                                       style="margin-right:5px;" class="btn btn-sm btn-info btn-outline pull-right" data-toggle="tooltip"  title="Ver Correio!">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                    @endforeach
                </table>
                <div class="pull-right">
                    @if( count($correios) >= 1)
                        {{ $correios->links() }}
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script src="{{ url('js/jquery-ui.js') }}"></script>

    <script>
        $(document).ready(function () {
            //PESQUISA
            $('input:text').bind({
            });
            $( "#pesquisa_correio" ).autocomplete({
                minLength:1,
                autoFocus: true,
                source: '{{URL('/correios/getdatacorreio')}}',
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop