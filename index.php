<?php
include "connection.php";
session_start();
if(isset($_SESSION["auth"])) {
  if($_SESSION["auth"] == "SIx3") {
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlusu = "SELECT * from tipo_usuario where id='1'";
    $resultusu = $mysqli->query($sqlusu);
    $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
    $desc_tipo_usuario = $rowusu[1];
    if ($_SESSION["user_type"] == $desc_tipo_usuario) {
      // is ADMIN
      header('Location: admin.php');
    } else {
      header('Location: client.php');
    }
  }
}
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

  <body class="grey darken-4">
<!--Barra de navegación-->
    <?php
    include 'navbar.php';
    ?>
<!--Primer Banner-->
    <div id="index-banner" class="parallax-container">
      <div class="section no-pad-bot">
        <div class="container">
          <br><br>
          <h1 class="header center white-text text-lighten-2">¿Unas Polas?</h1>
          
          <div class="row center">
            <h5 class="header col s12">Bienvenid<span class="lime-text text-lighten-1">@</span> a Zuleny's Bar</h5>
          </div>
          
          <div class="row center">
            <a href="#login" id="download-button" class="btn waves-effect waves-light light-green">Iniciar Sesión</a>
          </div>
        </div>
      </div>
      <div class="parallax"><img src="res/wall6.png" alt="Unsplashed background img 1"></div>
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
              echo "'El password del usuario no coincide.'";
            if ($msg == 2)
              echo "'No hay usuarios con el login (usuario) ingresado o está inactivo.'";
            if ($msg == 3)
              echo "'No se ha logueado en el sistema. Por favor ingrese los datos.'";
            if ($msg == 4)
              echo "'Su tipo de usuario, no tiene las credenciales suficientes para ingresar a esta opción.'";
            if ($msg == 5)
              echo "'Usted se encuentra logeado actualmente. Para crear una cuenta nueva, cierre su sesión.'";
            if ($msg == 6)
              echo "'¡Hasta la vista, baby!'";
          ?> 
          , 16000, 
          <?php 
            if ($msg == 1)
              echo "'red white-text'";
            if ($msg == 2)
              echo "'red white-text'";
            if ($msg == 3)
              echo "'indigo white-text'";
            if ($msg == 4)
              echo "'indigo white-text'";
            if ($msg == 5)
              echo "'blue white-text darken-2'";
            if ($msg == 6)
              echo "'purple darken-3 white-text'";
          ?> 
          );
        });
      </script>
    <?php 
      }
    }
    ?>
<!-- Login Dialog -->
    <?php 
    include 'login.modal.php';
    ?>
<!--Seccion de íconos-->
    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m4">
            <div class="icon-block">
              <h2 class="center lime-text"><i class="material-icons">add_circle_outline</i></h2>
              <h5 class="center white-text">Acceso rápido</h5>

              <p class="light white-text">
              	Realiza tus pedidos de bebidas en forma rápida, y observa el estado del mismo desde tu mesa. Solo presiona el botón de la <span class="lime-text">parte inferior derecha</span> de la pantalla y sigue las instrucciones. 
              </p>
            </div>
          </div>

          <div class="col s12 m4">
            <div class="icon-block">
              <h2 class="center lime-text"><i class="material-icons">music_video</i></h2>
              <h5 class="center white-text">Pide canciones</h5>

              <p class="light white-text">
              	Puedes pedir canciones en cualquier momento. Usa el botón de <span class="lime-text">acceso rápido</span> para acceder a cientas de canciones y reproducirlas en el sistema automatizado de reproducción del bar.
              </p>
            </div>
          </div>

          <div class="col s12 m4">
            <div class="icon-block">
              <h2 class="center lime-text"><i class="material-icons">weekend</i></h2>
              <h5 class="center white-text">¡No te levantes!</h5>

              <p class="light white-text">
              	Realiza toda la interacción con el bar desde tu mesa y monitorea el estado de tu pedido. Revisa nuestro catálogo en cualquier momento y... <span class="lime-text">¡Encuentra bebidas que no sabias ni que existían!</span>.
              </p>
            </div>
          </div>
        </div>
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
        $('.parallax').parallax();
      });       
    </script>
  </body>
</html>