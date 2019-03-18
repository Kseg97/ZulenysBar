<?php
include "connection.php";

session_start();

if (!isset($_GET["tab"])) 
    header('Location: admin.php?tab=1');

if(isset($_SESSION["auth"])) {
  if($_SESSION["auth"] == "SIx3") {
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlusu = "SELECT * from tipo_usuario where id='1'";
    $resultusu = $mysqli->query($sqlusu);
    $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
    $desc_tipo_usuario = $rowusu[1];
    if ($_SESSION["user_type"] != $desc_tipo_usuario)
      header('Location: client.php');
  } else header('Location: index.php');
} else header('Location: index.php');
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
      <!--ChartJS-->
      <script src="js/canvasjs.min.js"></script>
  </head>

  <body class="white">
    <!--Barra de navegación-->
    <?php
    include 'navbar.php';
    ?>
<!--Content-->
    <!-- Tabs (only for Desktop/Tablet)(see ui/navbar for Mobile)-->    
    <div class="row show-on-medium-and-up hide-on-small-only" style="margin-top: 5px; min-height: 80vh;">
        <ul class="tabs">
            <li class="tab col s3"><a class="active" href="#manage_users">Adm. de Usuarios</a></li>
            <li class="tab col s3"><a href="#manage_drinks">Adm. de Bebidas</a></li>
            <li class="tab col s3"><a href="#manage_music">Adm. de Canciones</a></li>
            <li id="tab_reports_n_ambient" class="tab col s3"><a href="#reports_n_ambient">Informes y Ambiente</a></li>
        </ul>
        <div id="manage_users">
            <?php 
            include 'admin/manage_users.php';
            ?>
        </div>
        <div id="manage_drinks">
            <?php 
            include 'admin/manage_drinks.php';
            ?>
        </div>
        <div id="manage_music">
            <?php 
            include 'admin/manage_music.php';
            ?>
        </div>
        <div id="reports_n_ambient">
            <?php 
            include 'admin/reports_n_ambient.php';
            ?>
        </div>
    </div>    
    <!-- End of tabs -->
    <!-- Content on Mobile-->
    <div class="row show-on-small hide-on-med-and-up" style="margin-top: 5px; min-height: 90vh;">
        <?php
        $tab = $_GET["tab"];
        switch ($tab) {
            case '1':
                include 'admin/m_manage_users.php';
                break;
            case '2':
                include 'admin/m_manage_drinks.php';
                break;
            case '3':
                include 'admin/m_manage_music.php';
                break;
            case '4':
                include 'admin/m_reports_n_ambient.php';
                break;
            default:
                include 'admin/m_manage_users.php';
                break;
        }
        ?>        
    </div>
    <!--End of Content-->
    <!--Footer-->
    <?php 
    include 'footer.php';
    ?>
<!--Scripts-->
    <script src="js/canvasjs.min.js"></script>

    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

    <script src="js/jquery.knob.min.js"></script>

    <script type="text/javascript">        
        $(document).ready(function(){
            $('.tabs').tabs();
            $('ul.tabs').tabs('select_tab', 
                <?php 
                $tab = $_GET["tab"];
                switch ($tab) {
                    case '1':
                        echo "'manage_users'";
                        break;
                    case '2':
                        echo "'manage_drinks'";
                        break;
                    case '3':
                        echo "'manage_music'";
                        break;
                    case '4':
                        echo "'reports_n_ambient'";
                        break;
                    default:
                        echo "'manage_users'";
                        break;
                }
                ?>);
            window.dispatchEvent(new Event('resize'));
            $( "#tab_reports_n_ambient" ).on( "click", function() {
                window.location.replace('admin.php?tab=4');
});
        });     
    </script>
  </body>
</html>