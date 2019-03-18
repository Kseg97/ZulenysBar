<?php
include "connection.php";                                                 
if(!isset($_SESSION)) 
    session_start(); 
?>
<!--Barra de navegación-->
<nav class="white" role="navigation">
    <div class="nav-wrapper container">
    <a id="logo-container" href="index.php" class="brand-logo hide-on-small-only"><img src="res/logo_512.png" alt="Logo" height="62"></a>
    <a id="logo-container" href="index.php" class="brand-logo hide-on-med-and-up"><img src="res/logo_512.png" alt="Logo" height="56"></a>
        
    <ul class="right hide-on-med-and-down">
        <?php         
        if (isset($_SESSION["auth"])) {
            if ($_SESSION["auth"] == "SIx3") {
        ?>
<!-- LoggedIn Content (Desktop) -->
        <ul class="collection" style="margin-top: 0px; margin-bottom: -20px; padding-right: 55px;">
        <li class="collection-item avatar white" style="margin-bottom: -22px;">
        <i class="circle material-icons light-green darken-3 z-depth-2">account_circle</i>
            <span class="title black-text"><?php  echo ucwords(strtolower($_SESSION["person_name"]));?></span>
            <p class="light-green-text text-darken-2"><?php  echo strtoupper($_SESSION["user_type"]);?>
            </p>
            <a href="logout.php" class="secondary-content light-green-text text-darken-4" style="margin-top: -16px; margin-right: -71px;"><i class="material-icons" style="font-size: 40px;">power_settings_new</i></a>
        </li>
        </ul>
<!-- End of Content -->
        <?php
            } else {
        ?>
                <li>
                <a href="#login" class="waves-effect waves-light btn-flat"><i class="material-icons right lime-text text-darken-1">account_circle</i>Ingresar</a>
                </li>
                <li>
                <a href="signup.php" class="waves-effect waves-light btn-flat"><i class="material-icons right lime-text text-darken-1">person_add</i>Registrarse</a>
                </li>
        <?php
            }
        } else {
        ?>
        <li>
        <a href="#login" class="waves-effect waves-light btn-flat"><i class="material-icons right lime-text text-darken-1">account_circle</i>Ingresar</a>
        </li>
        <li>
        <a href="signup.php" class="waves-effect waves-light btn-flat"><i class="material-icons right lime-text text-darken-1">person_add</i>Registrarse</a>
        </li>
        <?php
        }
        ?>
    </ul>

    <ul id="nav-mobile" class="side-nav lime lighten-4 black-text">
        <li class="light-green darken-1" style="padding-top: 5px; padding-bottom: 5px">
        <img src="res/trex_logo_black-transp_256.png" height="64px" style="display: block;  margin: 0 auto;">
        </li>
        <?php         
        if (isset($_SESSION["auth"])) {
            if ($_SESSION["auth"] == "SIx3") {
        ?>
<!-- LoggedIn Content (Tablet & Phone) -->
        <ul class="collection" style="margin-top: -1px;">
            <li class="collection-item avatar lime" style="margin-bottom: -19px;">
            <i class="circle material-icons light-green darken-3 z-depth-2">account_circle</i>
                <span class="title black-text"><?php  echo ucwords(strtolower($_SESSION["person_name"]));?></span>
                <p class="light-green-text text-darken-2"><?php  echo strtoupper($_SESSION["user_type"]);?>
                </p>
                <a href="logout.php" class="secondary-content" style="margin-top: -8px; margin-right: -45px;"><i class="material-icons" style="font-size: 40px;">power_settings_new</i></a>
            </li>
        </ul>
        <!--Tabs content instead (only for Phone)(see admin/client for Desktop/Tablet) -->
        <!--Admin-->
        <?php
        $mysqli = new mysqli($host, $user, $pw, $db);
        $sqlusu = "SELECT * from tipo_usuario where id='1'";
        $resultusu = $mysqli->query($sqlusu);
        $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
        $desc_tipo_usuario = $rowusu[1];
        if ($_SESSION["user_type"] == $desc_tipo_usuario) {
        ?>
        <li class="show-on-small hide-on-med-and-up">
            <a href="?tab=1" style="font-size: 14px;">
                <i class="material-icons" style="font-size: 30px;">account_circle</i>ADM. DE USUARIOS
            </a>
        </li>
        <li class="show-on-small hide-on-med-and-up">
            <a href="?tab=2" style="font-size: 14px;">
                <i class="material-icons" style="font-size: 30px;">add_circle</i>ADM. DE BEBIDAS
            </a>
        </li>
        <li class="show-on-small hide-on-med-and-up">
            <a href="?tab=3" style="font-size: 14px;">
                <i class="material-icons" style="font-size: 30px;">library_music</i>ADM. DE CANCIONES
            </a>
        </li>
        <li class="show-on-small hide-on-med-and-up">
            <a href="?tab=4" style="font-size: 14px;">
                <i class="material-icons" style="font-size: 30px;">insert_chart</i>INFORMES Y AMBIENTE
            </a>
        </li>
        <?php
        } else {
        ?>
        <!--Client-->
        <li class="show-on-small hide-on-med-and-up">
            <a href="?tab=1" style="font-size: 14px;">
                <i class="material-icons" style="font-size: 30px;">account_circle</i>MI PERFIL
            </a>
        </li>
        <li class="show-on-small hide-on-med-and-up">
            <a href="?tab=2" style="font-size: 14px;">
                <i class="material-icons" style="font-size: 30px;">library_music</i>COLA DE CANCIONES
            </a>
        </li>
        <?php
        }
        ?>
<!-- End of Content -->
        <?php
            } else {
        ?>
                <li><a href="#login" style="font-size: 14px;"><i class="material-icons" style="font-size: 30px;">account_circle</i>INGRESAR</a></li>
                <li><a href="signup.php" style="font-size: 14px;"><i class="material-icons" style="font-size: 30px;">person_add</i>REGISTRARSE</a></li>
        <?php
            }
        } else {
        ?>
        <li><a href="#login" style="font-size: 14px;"><i class="material-icons" style="font-size: 30px;">account_circle</i>INGRESAR</a></li>
        <li><a href="signup.php" style="font-size: 14px;"><i class="material-icons" style="font-size: 30px;">person_add</i>REGISTRARSE</a></li>
        <?php
        }
        ?>
    </ul>

    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons light-green-text">menu</i></a>
    </div>
</nav>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.button-collapse').sideNav();       
    });     
</script>