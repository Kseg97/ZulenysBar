<?php
include "connection.php";
                                                 
session_start();

if (isset($_SESSION["auth"]))
    if ($_SESSION["auth"] == "SIx3")
        header('Location: index.php?msg=5');

if ((isset($_POST["sent"]))) {
    $person_name = $_POST["person_name"];
    $person_name = str_replace("ñ","n",$person_name);
    $person_name = str_replace("Ñ","N",$person_name);
    $person_cc = $_POST["person_cc"];
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
    $user_password_enc = md5($user_password);
    $person_bd = $_POST["person_bd"];
    $email = $_POST["email"];

    //echo "<script type='text/javascript'>alert('$person_bd');</script>";
    //sleep(15);
    $person_bd = date("Y-m-d H:i:s", strtotime($person_bd));
    
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlcon = "SELECT * from usuarios where user_name='$user_name'";
    $resultcon = $mysqli->query($sqlcon);
    $rowcon = $resultcon->fetch_array(MYSQLI_NUM);
    $numero_filas = $resultcon->num_rows;
    if ($numero_filas > 0) {    
        header('Location: signup.php?msg=1');//
    } else {
        $sql = "INSERT INTO usuarios(tipo_usuario, nombre_persona, cedula, password, user_name, activo, fecha_nacimiento, email) 
        VALUES ('2','$person_name','$person_cc','$user_password_enc','$user_name','1', '$person_bd', '$email')";
        $result1 = $mysqli->query($sql);        
        if ($result1 == 1){
            echo "
            <html>
                <head>
                    <meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
                    <title>Procesando...</title>
                    <script type='text/javascript'>
                        function enviarForm(){
                            document.nameForm.submit();
                        }
                    </script>
                </head>
                <body onLoad='javascript:enviarForm();'>
                    <form name='nameForm' action='login.php' method='post'>
                        <input type='hidden' name='login1' value='{$user_name}'/>
                        <input type='hidden' name='passwd1' value='{$user_password}'/>
                    </form>
                </body>
            </html>";
        } else
            header('Location: signup.php?msg=2');    
    }
} else {
?>

<!DOCTYPE html>
<html lang="es">
  <head>
      <title>Zuleny's Bar</title>
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

  <body class="lime lighten-4">
<!--Barra de navegación-->
    <?php
    include 'navbar.php';
    ?>
<!--Login Dialog-->
    <?php 
    include 'login.modal.php';
    ?>
<!--Formulario-->
    <div class="row" style="min-height: 90vh;">
        <div class="col  m8 offset-m2">
            <div class="card-panel white z-depth-3 hoverable">
                <h5 class="grey-text left-align" style="margin-top:25px;">Registro </h5>
                <hr>
                <form class="cols12" id="form1" method="post" action="signup.php">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_name" name="person_name" type="text" class="validate" required>
                            <label for="person_name">Nombre Completo</label>
                        </div>

                        <div class="input-field col s6">
                            <input id="person_cc" name="person_cc" type="number" class="validate" required>
                            <label for="person_cc">Cédula</label>
                        </div>

                        <div class="input-field col s6">
                            <input id="person_bd" name="person_bd" type="text" class="datepicker" step="1" name="fecha_nac" required="" aria-required="true">
                            <label for="person_bd">Fecha de nacimiento</label>
                        </div>

                        <div class="input-field col s6">
                            <input id="user_name" name="user_name" type="text" class="validate" required>
                            <label for="user_name">Username</label>
                        </div>

                        <div class="input-field col s6">
                            <input id="user_email" name="email" type="email" class="validate" required>
                            <label for="user_email">Email</label>
                        </div>

                        <div class="input-field col s12">
                            <input id="user_password" name="user_password" type="password" class="validate" required>
                            <label for="user_password">Password</label>
                        </div>
                    </div>

                    <input type="hidden" value="true" name="sent">

                    <div class="row right-align">
                        <button class="btn waves-effect waves-light btn-small light-green" type="submit" name="submit" id="connect1">Registrarme</button>
                    </div>
                </form> 

                <div id="snipper1" class="progress lime">
                    <div class="indeterminate light-green"></div>
                </div> 
            </div>
            <!-- Notifications -->
            <?php
            if (isset($_GET["msg"])) {
                $msg = $_GET["msg"];
                if ($_GET["msg"]!="") {
            ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                    Materialize.toast(
                    <?php 
                        if ($msg == 1)
                            echo "'El username ya se encuentra registrado.'";
                        if ($msg == 2)
                            echo "'¡Ooops! Ha ocurrido un error. Por favor contacta al administrador.'";
                    ?> 
                    , 16000, 
                    <?php 
                        if ($msg == 1 || $msg == 2)
                            echo "'red white-text'";
                    ?> 
                    );
                    });
                </script>
            <?php 
                }
            }
            ?>
        </div>
    </div>
<!--Footer-->
    <?php 
    include 'footer.php';
    ?>
<!--Scripts-->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#toast-container .toast', function() {
            $(this).fadeOut(function(){
            $(this).remove();
            });
        });
        $(document).ready(function(){
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 50, // Creates a dropdown of 15 years to control year,
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true // Close upon selecting a date,
            });

            $('#snipper1').hide(); 

            $('form1').submit(function(){            
                $('#snipper1').show();
                $('#form').hide();
                $('#connect1').hide();       
            });
        });       
    </script>
  </body>
</html>
<?php
}
?>