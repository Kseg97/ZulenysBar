<?php
include(__DIR__ . '/../connection.php');

if(!isset($_SESSION))                                                
    session_start();
    
if ($_SESSION["auth"] != "SIx3") 
    header('Location: index.php?msg=3');
else {
  $mysqli = new mysqli($host, $user, $pw, $db);
  $sqlusu = "SELECT * from tipo_usuario where id='1'"; 
  $resultusu = $mysqli->query($sqlusu);
  $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
  $desc_tipo_usuario = $rowusu[1];
  if ($_SESSION["user_type"] != $desc_tipo_usuario)
    header('Location: index.php?mensaje=4');
}

$sql_hist_temp_1 = "SELECT * FROM datos_medidos where ID_TARJ='1' order by id desc limit 30";
$result_hist_temp_1 = $mysqli->query($sql_hist_temp_1);

$sql_hist_temp_2 = "SELECT * FROM datos_medidos where ID_TARJ='2' order by id desc limit 30";
$result_hist_temp_2 = $mysqli->query($sql_hist_temp_2);

$sql_datos_max = "SELECT * FROM datos_maximos WHERE id='1'";
$result_datos_max = $mysqli->query($sql_datos_max);
$row_datos_max = $result_datos_max->fetch_array(MYSQLI_NUM);
if($row_datos_max[1] == "temperatura"){
    $max_temp = $row_datos_max[3];
    $min_temp = $row_datos_max[2];
}else header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Informes y Reportes - Zuleny's Bar</title>
    </head>

    <body class="white">
        <div class="container">
            <h5 class="lime-text left-align" style="margin-top:25px;">Informes y Reportes</h5>
<!--Content-->
            <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-4 z-depth-4">
                            <div class="card-tabs">
                                <ul class="tabs tabs-transparent">
                                <li class="tab col s3"><a href="#m_tab1" class="">Temperatura en Tiempo Real</a></li>
                                <li class="tab col s3"><a class="active" href="#m_tab2">Histórico de Temperaturas</a></li>
                                <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                            </div>
                            <div class="card-content white grey-text text-darken-3">
                                <div id="m_tab1" style="display: none;" class="">
                                    <div id="m_chartRealtime" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                                </div>
                                <div id="m_tab2" class="active" style="display: block;">
                                    <div id="m_chartHistory" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--End of Content-->
        </div>
        <script type="text/javascript">        
            $(document).ready(function(){
                $('.tabs').tabs();
            });       
        </script>
        <script>
            window.onload = function () {
                var chart = new CanvasJS.Chart("m_chartRealtime", {
                    title: {
                        text: "Temperatura en Tiempo Real"
                    },
                    axisY: {
                        title: "Temperature (°C)",
                        suffix: " °C"
                    },
                    data: [{
                        type: "column",	
                        yValueFormatString: "#,### °C",
                        indexLabel: "{y}",
                        dataPoints: [
                            { label: "boiler1", y: 190 },
                            { label: "boiler2", y: 163 }
                        ]
                    }]
                });

                function updateChart() {
                    var boilerColor, deltaY, yVal;
                    var dps = chart.options.data[0].dataPoints;
                    for (var i = 0; i < dps.length; i++) {
                        deltaY = Math.round(2 + Math.random() *(-2-2));
                        yVal = deltaY + dps[i].y > 0 ? dps[i].y + deltaY : 0;
                        boilerColor = yVal > 200 ? "#FF2500" : yVal >= 170 ? "#FF6000" : yVal < 170 ? "#6B8E23 " : null;
                        dps[i] = {label: "Boiler "+(i+1) , y: yVal, color: boilerColor};
                    }
                    chart.options.data[0].dataPoints = dps; 
                    chart.render();
                };
                updateChart();

                setInterval(function() {updateChart()}, 500);

                var chart2 = new CanvasJS.Chart("m_chartHistory", {
                title:{
                    text: "Histórico de Temperaturas"
                },
                axisY:[{
                    title: "Mesa 1",
                    lineColor: "#C25F00",
                    tickColor: "#C25F00",
                    labelFontColor: "#C25F00",
                    titleFontColor: "#C25F00",
                    suffix: "°",
                    stripLines: [{
                        value: <?php echo $max_temp; ?>,
                        label: "Maximo (<?php echo $max_temp; ?>°)"
                    },
                    {
                        value: <?php echo $min_temp; ?>,
                        label: "Minimo (<?php echo $min_temp; ?>°)"
                    }]
                },
                {
                    title: "Mesa 2",
                    lineColor: "#5F9E00",
                    tickColor: "#5F9E00",
                    labelFontColor: "#5F9E00",
                    titleFontColor: "#5F9E00",
                    suffix: "°"
                }],
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "line",
                    name: "Mesa 2",
                    color: "#5F9E00",
                    showInLegend: true,
                    axisYIndex: 1,
                    dataPoints: [
                        <?php
                        while($row_hist_temp_2 = $result_hist_temp_2->fetch_array(MYSQLI_NUM)) {
                            echo "{ x: new Date('".$row_hist_temp_2[3]."T".$row_hist_temp_2[4]."Z'), y: ".$row_hist_temp_2[2]." },";
                        }
                        ?>
                    ]
                },
                {
                    type: "line",
                    name: "Mesa 1",
                    color: "#C25F00",
                    axisYIndex: 0,
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        while($row_hist_temp_1 = $result_hist_temp_1->fetch_array(MYSQLI_NUM)) {
                            echo "{ x: new Date('".$row_hist_temp_1[3]."T".$row_hist_temp_1[4]."Z'), y: ".$row_hist_temp_1[2]." },";
                        }
                        ?>
                    ]
                }]
            });
            chart2.render();

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }

            }
            </script>
    </body>
</html>