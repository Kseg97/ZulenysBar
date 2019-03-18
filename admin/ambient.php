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
            height: 400px !important;
        }
    </style>
    <!-- SLIDER -->
    <div class="carousel carousel-slider center" data-indicators="true">
    <!-- For Sider -->
        <div class="carousel-fixed-item center middle-indicator">
            <div class="left">
                <a href="Previo" class="movePrevCarousel middle-indicator-text content-indicator"><i class="material-icons left  middle-indicator-text">chevron_left</i></a>
            </div>
            
            <div class="right">
                <a href="Siguiente" class=" moveNextCarousel middle-indicator-text content-indicator"><i class="material-icons right middle-indicator-text">chevron_right</i></a>
            </div>
        </div>
        <!-- Panel filling (images) -->
        <div class="carousel-item lime grey-text text-darken-3">
            <h2>Rentty es entretenimiento</h2>
        </div>
        <div class="carousel-item green white-text">
            <h2>Rentty es entretenimiento</h2>
        </div>
        <div class="carousel-item light-green white-text">
            <h2>Rentty es entretenimiento</h2>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5 class="light-green-text left-align" style="margin-top:25px;">Control de Ambiente</h5>
<!--Content-->
            <div class="card grey darken-4  z-depth-4">
                <div class="card-tabs">
                    <ul class="tabs tabs-transparent">
                    <li class="tab col s2"><a class="active" href="#temp" class="">Temperatura</a></li>
                    <li class="tab col s2"><a href="#other">Otros</a></li>
                    <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                </div>
                <div class="card-content grey darken-4 lime-text">
                    <div id="temp" class="active" style="display: block;">
                        <form action="admin.php?tab=1" method="post">
                            <div class="row" style="display: flex; justify-content: center">
                                <div class="">
                                    <input name="maxval" class="knob rigth-align" data-angleOffset=-125 data-angleArc=250 data-cursor=true data-thickness=.3 data-fgColor="#CDDC39" data-bgColor="#424242" data-rotation="anticlockwise" value="<?php echo $max_temp; ?>">
                                </div>
                                <div class="center-align">
                                    <b>MAX | MIN</b>
                                </div>
                                <div class="">
                                    <input name="minval" class="knob" data-angleOffset=-125 data-angleArc=250 data-cursor=true data-thickness=.3 data-fgColor="#CDDC39" data-bgColor="#424242" data-rotation="anticlockwise" value="<?php echo $min_temp; ?>">
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
                    <div id="other" style="display: none;" class="">
                        2
                    </div>
                </div>
            </div>
<!--End of Content-->
        </div>
    </div>
    <script type="text/javascript">        
        $(document).ready(function(){            
            $('.tabs').tabs();
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

            // move next carousel
            $('.moveNextCarousel').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.carousel').carousel('next');
            });

            // move prev carousel
            $('.movePrevCarousel').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $('.carousel').carousel('prev');
            });

            /////
            $('.next').click(function(){ $('.carousel').carousel('next');return false; });
            $('.prev').click(function(){ $('.carousel').carousel('prev');return false; });
        });       
    </script>
  </body>
</html>