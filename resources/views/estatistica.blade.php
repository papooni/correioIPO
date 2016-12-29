@extends('layouts.dashboard')
@section('page_heading','Estatística Mensal de ' . $ano)
@section('section')


    <script>
        var meses =  <?php echo json_encode($meses, JSON_FORCE_OBJECT); ?>;
        $(function(){
            var  graficoLinhas = {
                labels:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
                datasets : [
                    {
                        label: "Estatística Mensal",
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "",
                        pointColor: "",
                        pointStrokeColor: "",
                        pointHighlightFill: "",
                        pointHighlightStroke: "",
                        data : [meses[0],meses[1],meses[2],meses[3],meses[4],meses[5],meses[6],meses[7],meses[8],meses[9],meses[10],meses[11]]
                    }
                ]
            }
            var linhas = document.getElementById("linhas").getContext("2d");
            new Chart(linhas).Line(graficoLinhas,{
                responsive: true
            });
        });
    </script>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <canvas id="linhas" width="100" height="50"></canvas>
        </div>
    </div>

@stop