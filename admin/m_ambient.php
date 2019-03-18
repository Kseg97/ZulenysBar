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
      <title>Control de Ambiente - Zuleny's Bar</title>
  </head>

<body class="white">
    <div class="row">
        <div class="col s12">
            <h5 class="light-green-text  left-align" style="margin-top:25px;">Control de Ambiente</h5>
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
                            <div class="row" style="justify-content: center">
                                <div class="col s12 center-align">
                                    <input name="maxval" class="knob rigth-align" data-angleOffset=-125 data-angleArc=250 data-cursor=true data-thickness=.3 data-fgColor="#CDDC39" data-bgColor="#424242" data-rotation="anticlockwise" value="<?php echo $max_temp; ?>">
                                </div>
                                <div class="col s12 center-align">
                                    <b>MAX <hr> MIN  </b><br>
                                </div>
                                <div class="col s12 center-align" style="padding-top:40px;">
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
        });       
    </script>
  </body>
</html>