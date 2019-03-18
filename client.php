<?php
include "connection.php";

session_start();

if (!isset($_GET["tab"])) 
    header('Location: client.php?tab=1');

if(isset($_SESSION["auth"])) {
  if($_SESSION["auth"] == "SIx3") {
    $mysqli = new mysqli($host, $user, $pw, $db);
    $sqlusu = "SELECT * from tipo_usuario where id='2'";
    $resultusu = $mysqli->query($sqlusu);
    $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
    $desc_tipo_usuario = $rowusu[1];
    if ($_SESSION["user_type"] != $desc_tipo_usuario)
      header('Location: admin.php');
  } else header('Location: index.php');
} else header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <title>Cliente - Zuleny's Bar</title>
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
    <div class="row show-on-medium-and-up hide-on-small-only" style="margin-top: 5px; min-height: 90vh;">
        <div class="col s12">
            <ul class="tabs"><!--add lista canciones-->
                <li class="tab col s4"><a class="active" href="#profile">Mi perfil</a></li>
                <li class="tab col s4"><a href="#music_queue">Cola de Canciones</a></li>
            </ul>
        </div>
        <div id="profile" class="col s12">
            <?php 
            include 'client/profile.php';
            ?>
        </div>
        <div id="music_queue" class="col s12">
            <?php 
            include 'client/music_queue.php'; 
            ?>
        </div>
    </div>    
    <!-- End of tabs -->
    <!-- Content on Mobile-->
    <div class="row show-on-small hide-on-med-and-up" style="margin-top: 5px; min-height: 60vh;">
        <?php
        $tab = $_GET["tab"];
        switch ($tab) {
            case '1':
                include 'client/m_profile.php';
                break;
            case '2':
                include 'client/m_music_queue.php';
                break;
            default:
                include 'client/m_profile.php'; //De la version movil me encargo
                break;
        }
        ?>        
    </div>
    <!--End of Content-->
    <!--Footer-->
    <?php 
    include 'footer.php';
    ?>
    <!--Floating Button-->
    <div class="fixed-action-btn horizontal">
        <a class="btn-floating btn-large pulse light-green">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <!--maybe use a modal for logout since it´s close to add-->
            <li><a href="logout.php" class="btn-floating btn-floating-option red"><i class="material-icons">power_settings_new</i></a></li>
            <li><a href="new_request.php" class="btn-floating btn-floating-option green"><i class="material-icons">add_circle</i></a></li>
        </ul>
    </div>
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
                        echo "'profile'";
                        break;
                    case '2':
                        echo "'music_queue'";
                        break;
                    default:
                        echo "'profile'";
                        break;
                }
                ?>);
            window.dispatchEvent(new Event('resize'));
            $('.fixed-action-btn').openFAB();
            $('.fixed-action-btn').closeFAB();
        });      
    </script>
  </body>
</html>