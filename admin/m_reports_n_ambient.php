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
    header('Location: index.php?msg=4');
}

if(isset($_POST["updatemax"])){
    $new_max = $_POST["maxval"];
    $new_min = $_POST["minval"];
    $sql_update_max = "UPDATE datos_maximos SET maximo='$new_max' WHERE id='1'";
    $result_update_max = $mysqli->query($sql_update_max);
    $max_temp = $new_max;
    $min_temp = $new_min;
    $sql_update_min = "UPDATE datos_maximos SET minimo='$new_min' WHERE id='1'";
    $result_update_min = $mysqli->query($sql_update_min);
}

$sql_hist_temp_1 = "SELECT * FROM datos_medidos where ID_TARJ='1' AND fecha >= current_date - interval 1 day";
$sql_hist_temp_2 = "SELECT * FROM datos_medidos where ID_TARJ='2' AND fecha >= current_date - interval 1 day";
if(isset($_POST["submit_temp"])) {
    switch ($_POST["range_temp"]) {
        case '1':
        // 24h
            $sql_hist_temp_1 = "SELECT * FROM datos_medidos where ID_TARJ='1' AND fecha >= current_date - interval 7 day";
            $sql_hist_temp_2 = "SELECT * FROM datos_medidos where ID_TARJ='2' AND fecha >= current_date - interval 7 day";
            break;
        case '2':
        // 30d
            $sql_hist_temp_1 = "SELECT * FROM datos_medidos where ID_TARJ='1' AND fecha >= current_date - interval 30 day";
            $sql_hist_temp_2 = "SELECT * FROM datos_medidos where ID_TARJ='2' AND fecha >= current_date - interval 30 day";
            break;
    }
}
$result_hist_temp_1 = $mysqli->query($sql_hist_temp_1);
$result_hist_temp_2 = $mysqli->query($sql_hist_temp_2);

$sql_datos_max = "SELECT * FROM datos_maximos WHERE id='1'";
$result_datos_max = $mysqli->query($sql_datos_max);
$row_datos_max = $result_datos_max->fetch_array(MYSQLI_NUM);
if($row_datos_max[1] == "temperatura"){
    $max_temp = $row_datos_max[3];
    $min_temp = $row_datos_max[2];
}else header('Location: index.php');

$sql_music_song = "SELECT * FROM est_canciones_genre order by counter desc limit 5";
$result_music_song = $mysqli->query($sql_music_song);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <title>Reportes y Ambiente - Zuleny's Bar</title>
  </head>

<body class="white">
    <style>
        .middle-indicator{
            position:absolute;
            top:40%;
            }
            .middle-indicator-text{
            font-size: 4.2rem;
            }
            a.middle-indicator-text{
            color:white !important;
            }
        .content-indicator{
            width: 64px;
            height: 64px;
            background: none;
            -moz-border-radius: 50px;
            -webkit-border-radius: 50px;
            border-radius: 50px; 
            }
        .carousel-slider {
            min-height: 95vh !important;
        }
    </style>
    <!-- SLIDER -->
    <div class="carousel carousel-slider" data-indicators="true" style="margin-top:-4px;">
    <!-- For Sider -->
        <div class="carousel-fixed-item center middle-indicator">
            <div class="left">
                <a href="m_prev" class="movePrevCarousel middle-indicator-text content-indicator"><i class="material-icons left  middle-indicator-text">chevron_left</i></a>
            </div>
            
            <div class="right">
                <a href="m_next" class=" moveNextCarousel middle-indicator-text content-indicator"><i class="material-icons right middle-indicator-text">chevron_right</i></a>
            </div>
        </div>
        <!-- Panel filling (images) -->
        <div class="carousel-item grey darken-4 grey-text text-lighten-3" style="">
<!--REPORTS (TEMPERATURE)-->
            <div class="row" style="">
                <div class="col s10 offset-s1 " style="">
                    <div id="m_chartHistory" style="height: 370px; max-width: 80vw; position: absolute; margin: auto; top: 0; right: 0; bottom: 0; left: 0;"></div>
                </div>
                <form class="col s12 " method="POST" action="admin.php?tab=4">
                    <div class="grey darken-4 input-field col s6">
                        <select name="range_temp"> 
                            <option value=0>Desde hace un día</option>
                            <option value=1>Desde hace semana</option>
                            <option value=2>Desde hace un mes</option>
                        </select>
                        <label>Rango</label>
                    </div>
                    
                    <div class="col s6 right-align" style="padding-top:15px;">
                        <button class="btn waves-effect waves-light btn-small grey darken-3 lime-text" name="submit_temp" type="submit">Consultar</button>
                    </div>                               
                </form>
            </div>            
<!--END-->
        </div>
        <div class="carousel-item green darken-1 white-text">
<!--REPORTS (MUSIC Genre/Song)-->
            <div class="row" style="">
                <div class="col s10 offset-s1 " style="">
                    <div id="m_chartMusicGenre" style="height: 370px; max-width: 80vw; position: absolute; margin: auto; top: 0; right: 0; bottom: 0; left: 0;"></div>
                </div>
            </div>
<!--END-->
        </div>
        <div class="carousel-item lime white-text">
<!-- AMBIENTE (MAX/MIN TEMP, PLAYLIST) -->
            <div class="row">
                <div class="col s12">
                    <h5 class="green-text text-darken-4 left-align" style="margin-top:25px;">Control de Ambiente</h5>
                    <div class="card grey darken-4 z-depth-4">
                        <div class="card-tabs">
                            <ul class="tabs tabs-transparent">
                            <li class="tab col s2"><a class="active" href="#m_temp" class="">Temperatura</a></li>
                            <li class="tab col s2"><a href="#m_playlist">Playlist</a></li>
                            <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                        </div>
                        <div class="card-content grey darken-4 lime-text">
                            <div id="m_temp" class="active" style="display: block;">
                                <form action="admin.php?tab=1" method="post">
                                    <div class="row" style="justify-content: center">
                                        <div class="col s12 center-align">
                                            <input name="maxval" class="knob rigth-align" style="padding:0;" data-max="40" data-width="150" data-height="120" data-angleOffset=-125 data-angleArc=250 data-cursor=true data-thickness=.3 data-fgColor="#CDDC39" data-bgColor="#424242" data-rotation="anticlockwise" value="<?php echo $max_temp; ?>">
                                        </div>
                                        <div class="col s12 center-align">
                                            <b>MAX <hr> MIN  </b><br>
                                        </div>
                                        <div class="col s12 center-align" style="padding-top:10px;">
                                            <input name="minval" class="knob" style="padding:0;" data-width="150" data-max="40" data-height="120" data-angleOffset=-125 data-angleArc=250 data-cursor=true data-thickness=.3 data-fgColor="#CDDC39" data-bgColor="#424242" data-rotation="anticlockwise" value="<?php echo $min_temp; ?>">
                                        </div>                    
                                    </div> 
                                    <input type="hidden" value="true" name="updatemax">
                                    <div>
                                        <div class="col s12 center-align">
                                            <button type="submit" name= "submit" class="btn waves-effect lime grey-text text-darken-4 z-depth-4"><b>ACTUALIZAR</b></button>
                                        </div>
                                    </div> 
                                </form>                       
                            </div>
                            <div id="m_playlist" style="display: none;" class="">
                                <h6>Aquí va el control de playlist (CRUD) (porque es parte del ambiente).</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--END-->
        </div>
    </div>
    
    <script type="text/javascript">  
        $(window).on("load",function(){ 
            window.dispatchEvent(new Event('resize'));         
            $('.tabs').tabs();
            $('select').material_select();
            $(".knob").knob({
                    change : function (value) {
                        //console.log("change : " + value);
                    },
                    release : function (value) {
                        //console.log(this.$.attr('value'));
                        console.log("release : " + value);
                    },
                    cancel : function () {
                        console.log("cancel : ", this);
                    }
                });
            $('.carousel.carousel-slider').carousel({fullWidth: true});
                
            // move m_next carousel
            $('.moveNextCarousel').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.carousel').carousel('next');
            });

            // move m_prev carousel
            $('.movePrevCarousel').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $('.carousel').carousel('prev');
            });

            /////
            $('.m_next').click(function(){ $('.carousel').carousel('next');return false; });
            $('.m_prev').click(function(){ $('.carousel').carousel('prev');return false; });

            var m_chart2 = new CanvasJS.Chart("m_chartMusicGenre", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: "transparent",
                title:{
                    text: "Las 5 canciones más sonadas",
                    fontColor: "#F8F8F8",
                    fontFamily: "tahoma",
                    padding: {
                        bottom: 30,
                    }
                },
                toolTip: {
                    shared: true,
                    fontColor: "black",
                    content: "Reproducciones: {y}"
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                },
                axisY:[{
                    title: "Cantidad de reproducciones",
                    labelFontColor: "#FFFFFF",
                    titleFontColor: "#FFFFFF",
                }],
                axisX: {
                    labelFontColor: "#FFFFFF",
                },
                data: [{
                    type: "column",
                    showInLegend: true, 
                    legendMarkerColor: "#FFFFFF",
                    legendText: "Cantidad de reproducciones",
                    color: "#FFFFFF",
                    dataPoints: [
                        <?php
                        while($row_music_song = $result_music_song->fetch_array()) {
                            echo "{ label: '".substr($row_music_song['cancion'], 0, 15)."', y: ".$row_music_song['counter']." },";
                        }
                        ?>
                    ]
                }]
            });
            m_chart2.render();               

            var m_chart1 = new CanvasJS.Chart("m_chartHistory", {
                backgroundColor: "transparent",
                title:{
                    text: "Histórico de Temperaturas",
                    fontColor: "#F8F8F8",
                    fontFamily: "tahoma",
                    padding: {
                        bottom: 30,
                    }
                },
                axisY:[{
                    title: "Mesa 1",
                    lineColor: "#CDDC39",
                    tickColor: "#CDDC39",
                    labelFontColor: "#CDDC39",
                    titleFontColor: "#CDDC39",
                    suffix: "°",
                    stripLines: [{
                        value: <?php echo $max_temp; ?>,
                        label: "Máximo (<?php echo $max_temp; ?>°)",
                        color: "#FF791F",
                        labelFontColor: "#FF791F"
                    },
                    {
                        value: <?php echo $min_temp; ?>,
                        label: "Mínimo (<?php echo $min_temp; ?>°)",
                        color: "#3B89FD",
                        labelFontColor: "#3B89FD"
                    }]
                    },
                    {
                    title: "Mesa 2",
                    lineColor: "#FFFFFF",
                    tickColor: "#FFFFFF",
                    labelFontColor: "#FFFFFF",
                    titleFontColor: "#FFFFFF",
                    suffix: "°"
                }],
                axisX: {
                    labelFontColor: "#B8B8B8"
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    fontColor: "#B8B8B8"
                },
                data: [{
                    type: "spline",
                    name: "Mesa 2",
                    color: "#FFFFFF",
                    lineThickness: 4,
                    markerSize: 4,
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
                    type: "spline",
                    name: "Mesa 1",
                    color: "#CDDC39",
                    lineThickness: 4,
                    markerSize: 4,
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
            m_chart1.render();  

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }
        });       
    </script>
  </body>
</html>