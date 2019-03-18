<?php
include "connection.php";

session_start();

if (!isset($_GET["id"])) 
    header('Location: admin.php?tab=1');

if(isset($_SESSION["auth"])) {
  if($_SESSION["auth"] == "SIx3") {
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlusu = "SELECT * from tipo_usuario where id='1'";
    $resultusu = $mysqli->query($sqlusu);
    $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
    $desc_tipo_usuario_upt = $rowusu[1];
    if ($_SESSION["user_type"] != $desc_tipo_usuario_upt)
      header('Location: client.php');
  } else header('Location: index.php');
} else header('Location: index.php');


if ((isset($_POST["enviado"]))) {
    $id_usu_enc = $_POST["id_usu"];
    $nombre_usuario = $_POST["nombre_usuario"];
    $nombre_usuario = str_replace("ñ","n",$nombre_usuario);
    $nombre_usuario = str_replace("Ñ","N",$nombre_usuario);
    $num_id = $_POST["num_id"];
    $tipo_usuario_upt = $_POST["tipo_usuario"];
    $email = $_POST["email"];
    $activo = $_POST["activo"];
    $password = $_POST["password"];
    $id_tarjeta = $_POST["id_tarjeta"];
    $login = $_POST["login"];
    
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlu1 = "UPDATE usuarios set nombre_persona='$nombre_usuario' where id='$id_usu_enc'"; 
    $resultsqlu1 = $mysqli->query($sqlu1);
    $sqlu2 = "UPDATE usuarios set user_name='$login' where id='$id_usu_enc'"; 
    $resultsqlu2 = $mysqli->query($sqlu2);
    $sqlu3 = "UPDATE usuarios set cedula='$num_id' where id='$id_usu_enc'"; 
    $resultsqlu3 = $mysqli->query($sqlu3);
    $sqlu4 = "UPDATE usuarios set tipo_usuario='$tipo_usuario_upt' where id='$id_usu_enc'"; 
    $resultsqlu4 = $mysqli->query($sqlu4);
    $sqlu5 = "UPDATE usuarios set email='$email' where id='$id_usu_enc'"; 
    $resultsqlu5 = $mysqli->query($sqlu5);
    $sqlu7 = "UPDATE usuarios set activo='$activo' where id='$id_usu_enc'"; 
    $resultsqlu7 = $mysqli->query($sqlu7);

    if ($password != "") {
        $password_enc = md5($password);
        $sqlu9 = "UPDATE usuarios set password='$password_enc' where id='$id_usu_enc'"; 
        $resultsqlu9 = $mysqli->query($sqlu9);
    }  
 
    if ((($resultsqlu1 == 1) && ($resultsqlu2 == 1) && ($resultsqlu3 == 1) && ($resultsqlu4 == 1) && 
        ($resultsqlu5 == 1) && ($resultsqlu7 == 1)) || ($resultsqlu9 == 1))
        header('Location: admin.php?tab=1&msg=1');
    else
        header('Location: admin.php?tab=1&msg=2');
 
} else {
    $id_usu_enc = $_GET["id"];
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlenc = "SELECT * from usuarios";
    $resultenc = $mysqli->query($sqlenc);

    while($rowenc = $resultenc->fetch_array(MYSQLI_NUM)) {  
        $id_usu  = $rowenc[0];
        if (md5($id_usu) == $id_usu_enc)
            $id_usu_enc = $id_usu;
    }

    $sql1 = "SELECT * from usuarios where id='$id_usu_enc'";
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_array(MYSQLI_NUM);
    $nombre_usuario  = $row1[1];
    $tipo_usuario_upt  = $row1[6];
    $num_id = $row1[2];
    $email= $row1[8];
    $activo= $row1[7];
    $login= $row1[4];

    if ($activo == 1)
        $desc_activo = "S (Activo)";
    else
        $desc_activo = "N (Inactivo)";
    
    $sql3 = "SELECT * from tipo_usuario where id='$tipo_usuario_upt'";
    $result3 = $mysqli->query($sql3);
    $row3 = $result3->fetch_array(MYSQLI_NUM);
    $desc_tipo_usuario_upt = $row3[1];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <title>Admin - Zuleny's Bar</title>
      <!--Links para cs-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
      <link rel="stylesheet" type="text/css" href="styles.css">
      <!--Optimizacion en móbiles-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta charset="utf-8">
      <!--jquery-->
      <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script> 
  </head>

  <body class="grey lighten-4 black-text">
    <!--Barra de navegación-->
    <?php
    include 'navbar.php';
    ?>    
<!--Content-->
    <div class="container"> 
        <div class="row">
            <h5 class="green-text text-darken-1 left-align" style="margin-top:25px;">Modificar Usuario </h5>
            <hr>
            <div class="row">
                <form id="form_update" method="post" action="update.php">
                    <div class="input-field col s12">
                        <input id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario; ?>" type="text" class="validate" required>
                        <label for="nombre_usuario">Nombre Completo</label>
                    </div>

                    <div class="input-field col s6">
                        <input id="num_id" name="num_id" value="<?php echo $num_id;?>" type="number" class="validate" required>
                        <label for="num_id">Cédula</label>
                    </div>
                    
                    <div class="input-field col s6">
                        <input id="email" name="email" value="<?php echo $email;?>" type="email" class="validate" required>
                        <label for="email">Email</label>
                    </div>   

                    <div class="input-field col m6 s4">
                        <input id="login" name="login" value="<?php echo $login;?>" type="text" class="validate" required>
                        <label for="login">Username</label>
                    </div>

                    <div class="input-field col m6 s8">
                        <input id="password" name="password" type="password" class="validate">
                        <label for="password">Password (En blanco sin cambio)</label>
                    </div>     
                   
                    <div class="input-field col s6">
                        <select name="tipo_usuario" required>                        
                            <option value="<?php echo $tipo_usuario_upt; ?>"> <?php echo strtoupper($desc_tipo_usuario_upt); ?></option>  
                            <?php 	
                            $sql6 = "SELECT * from tipo_usuario";
                            $result6 = $mysqli->query($sql6);
                            while($row6 = $result6->fetch_array(MYSQLI_NUM)) {
                                $tipo_usuario_upt_con = $row6[0];
                                $desc_tipo_usuario_upt_con = $row6[1];
                                if ($tipo_usuario_upt_con != $tipo_usuario_upt) {
                            ?>   
                                <option value="<?php echo $tipo_usuario_upt_con; ?>"> <?php echo strtoupper($desc_tipo_usuario_upt_con); ?></option>  
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label>Tipo</label>
                    </div> 

                    <div class="input-field col s6">
                        <select name="activo" required>
                            <option value="<?php echo $activo; ?>"> <?php echo $desc_activo; ?></option>  
                        <?php
                        $activo_con = 1;
                        $desc_activo_con = "S (Activo)";
                        if ($activo_con != $activo) {
                        ?>   
                            <option value="<?php echo $activo_con; ?>"> <?php echo $desc_activo_con; ?></option>  
                        <?php
                        } else {    
                        ?>
                            <option value="0"> N (Inactivo)</option>  
                        <?php
                        }
                        ?>  
                        </select>
                        <label>Activo</label>
                    </div>                           

                    <input type="hidden" value="S" name="enviado">     
                    <input type="hidden" value="<?php echo $id_usu_enc; ?>" name="id_usu">

                    <div class="col s6 left-align">                
                        <button onclick="goBack()" class="btn waves-effect waves-light btn-small grey darken-4 white-text" type="button" id="volver" name="volver">Volver</button>              
                    </div>

                    <div class="col s6 right-align">
                        <button class="btn waves-effect waves-light btn-small lime black-text" type="submit" name="modificar" id="submit_update">Modificar</button>
                    </div>                    
                </form>                 
            </div>             
        </div>
    </div>
<!--End of Content-->
    <!--Footer-->
    <?php 
    include 'footer.php';
    ?>
<!--Scripts-->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">  
        function goBack() {
            window.history.back();
        }      
        $(document).ready(function(){
            $('select').material_select();
        });      
    </script>
  </body>
</html>
<?php
}
?>