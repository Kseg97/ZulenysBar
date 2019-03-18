<?php
include "connection.php";

session_start();

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

$pin = "''";
$allowed = "none";
if(isset($_GET["sent_request"]) && isset($_GET["pin_input"])){
    $pin_input =  $_GET["pin_input"];
    $sql_val_pin = "SELECT * FROM lista_pines where pin='$pin_input'";
    $result_val_pin = $mysqli->query($sql_val_pin);
    if($row = $result_val_pin->fetch_assoc()) {
        if($row["pin"] != null) {
            $pin = $pin_input;
            if(isset($_GET["sent_drinks"])) $allowed = "drinks";
            else $allowed = "music";
        } else header("Location: new_request.php?msg=2"); // Inval PIN
    } else header("Location: new_request.php?msg=3"); // SQL Error
}

if(isset($_POST["sent_music"])) {
    $allowed = "music";
    $pin = $_POST["sent_music"];
}
?>
<head>
    <title>Nuevo Pedido - Zuleny's Bar</title>
    <!--Links para cs-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
    <link rel="stylesheet" type="text/css" href="styles.css">
    
    <!--Optimizacion en móbiles-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8">
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--jquery-->
    <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script> 
    </head>
<body class="grey darken-4 lime-text">
    <!--Barra de navegación-->
    <?php
    include 'navbar.php';
    ?>
<!--Content-->
    <div class="row">
        <div class="col s12 m10 offset-m1 l6 offset-l3 ">
            <div class="card grey darken-4">
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width tabs-transparent">
                    <li class="tab"><a href="#pin" class="">INGRESA PIN</a></li>
                    <li class="tab <?php if($allowed != 'drinks') echo 'disabled'; ?>"><a href="#drinks">BEBIDAS</a></li>
                    <li class="tab <?php if($allowed != 'music') echo 'disabled'; ?>"><a href="#music" class="">CANCIONES</a></li>
                    <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                </div>
                <div class="card-content grey darken-3 grey-text text-lighten-3">
                    <div id="pin">
                        <form action="new_request.php" method="get">
                            <div class="row center-align">
                                <i class="material-icons large light-green black-text z-depth-2">check</i>
                                <h5 class="grey-text text-lighten-2">Ingresa el pin generado por el dispositivo en tu mesa. Mantén presionado el botón hasta que aparezca un nuevo PIN de cuatro dígitos</h5>
                            
                                <div class="input-field col s4 offset-s4">
                                    <input id="pin_input" name="pin_input" type="text" class="validate lime-text" placeholder="XXXX">
                                    <label for="pin_input">PIN</label>
                                </div>
                                <input type="hidden" name="sent_request" value=true>
                                <button name="sent_drinks" value=true class="col s6 btn btn-small waves-effect waves-black purple white-text z-depth-4" >PEDIR BEBIDA</button> 
                                <button name="sent_music" value=true class="col s6 btn btn-small waves-effect waves-black indigo white-text z-depth-3" >PEDIR CANCIÓN</button>    
                            </div>
                        </form>
                    </div>
                    <div id="drinks" style="display: block;">
                        <div class="row">
                            <div class="col s12 m5">
                                <select name="from[]" id="lstview" name="lstview" class="browser-default" size="8" style="height:200px; background-color:#FFF;border: 0px solid blue;">
                                    <?php
                                        if($allowed != "none") {
                                            $sql_bebidas = "SELECT * FROM lista_bebidas ";
                                            $result_bebidas = $mysqli->query($sql_bebidas);
                                            while($row_bebidas = $result_bebidas ->fetch_assoc()){
                                    ?>
                                    <option name="bebidas" value="<?php echo $row_bebidas['nombre'];?>" style="background-image: url('admin/uploads/<?php echo $row_bebidas['drink_img']; ?>'); background-repeat: no-repeat; background-size: 32px; padding: 9px 35px;color:#000;"> <?php echo $row_bebidas['nombre'];?> </option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <style>
                                    select:active, select:hover {
                                    outline-color: #CDDC39
                                    }
                                    select option:hover,
                                    select option:focus,
                                    select option:active {
                                        background: linear-gradient(#212121, #212121);
                                        background-color: #212121 !important; /* for IE */
                                        color: #CDDC39 !important;
                                    }

                                    select option:checked {
                                        background: linear-gradient(#CDDC39, #CDDC39) !important;
                                        background-color: #CDDC39 !important; /* for IE */
                                        color: #000000 !important;
                                    }
                                </style>
                            </div>
                                
                            <div class="col s12 m2" style="">                                
                                <button type="button" id="lstview_rightSelected" class="btn waves-effect waves-black light-green add"><i class="material-icons">keyboard_arrow_right</i></button>
                                <!--<button type="button" id="" class="btn waves-effect waves-black light-green add"><i class="material-icons">keyboard_arrow_right</i></button>-->
                                <button type="button" id="lstview_leftSelected" class="btn waves-effect waves-black red"><i class="material-icons">keyboard_arrow_left</i></button>
                            </div>
                                    
                            <div class="col s12 m5">
                                <select name="to[]" id="lstview_to" class="browser-default" size="8" multiple="multiple" style="height:200px; background-color:#FFF;border: 0px solid blue;">

                                </select>
                            </div>  
                        </div>
                        <div class="row">
                            <br>
                            <button disabled type="button" id="send" class="col s4 offset-s8 btn btn-small waves-effect waves-black lime black-text z-depth-3" >Pedir</button>
                        </div>
                    </div>
<!--FUNCIONALIDAD CLIENTE-PEDIDO CANCION -->
                    <div id="music" style="display: none;" class="">
                        <form action="new_request.php" method="POST">
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="song_name_qry" name="song_name_qry" type="text" class="validate">
                                    <label for="song_name_qry">Nombre de la canción</label>
                                </div> 
                                <input type="hidden" name="sent_music" value="<?php echo $pin;?>">
                                <div class="col s3">
                                    <button class="btn waves-effect waves-light btn-small lime" type="submit" style="margin-top: 15px;">Consultar</button>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr class="yellow-text">
                                    <th>Canción</th>
                                    <th>Género</th>
                                    <th>Reproducir</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ((isset($_POST["sent_music"]))) {
                                    $song_name_qry = $_POST["song_name_qry"];
                                    $sql_song = "SELECT * from lista_canciones where cancion LIKE '%$song_name_qry%' order by cancion";
                                    if($song_name_qry == "") "SELECT * from lista_canciones order by cancion";
                                } else $sql_song = "SELECT * from lista_canciones order by cancion";
                
                                $result_song = $mysqli->query($sql_song);
                                while($row_song = $result_song->fetch_array(MYSQLI_NUM)) {                        
                                    $song_name = $row_song[1];
                                    $song_genre = $row_song[2];
                                    $song_id = $row_song[0];
                            ?>
                                <tr>
                                    <td class="white-text"><?php echo $song_name; ?></td>
                                    <td>
                                    <?php 
                                    $sql_genre_id = "SELECT * from genero_canciones where id='$song_genre'";
                                    $result_genre_id = $mysqli->query($sql_genre_id);
                                    $row_genre_id = $result_genre_id->fetch_array();
                                    echo $row_genre_id[1]; 
                                    ?>
                                    </td>
                                    <td><a class="center-align" href="process_music_request.php?id=<?php echo $song_id.'&pin='.$pin; ?>">
                                    <i class="material-icons white-text" style="margin-left:25px;">play_arrow</i></a></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- FIN-->
                </div>
            </div>
        </div>
    </div>
<!--End of Content-->
<!--<select multiple="true" class="multiselect1 browser-default" name="myselecttsms1">
    <option value="1" rel="0" title="One">One</option>
    <option value="2" rel="1" title="Two">Two</option>            
    <option value="4" rel="3" title="Four">Four</option>
    <option value="5" rel="4" title="Five">Five</option>
    <option value="6" rel="5" title="Six">Six</option>
</select>

<select multiple="true" class="multiselect2 browser-default" name="myselecttsms2" size="6">
   
</select>


<button class="add">Add</button>
<button class="addAll">Add All</button>
<button class="remove">Remove</button>
<button class="removeAll">Remove All</button>-->
    <!-- Notifications(consider deleting) -->
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
                echo "'¡Pedido realizado! Revisa el dispositivo en tu mesa para ver el estado de tu pedido.'";
            if ($msg == 2)
                echo "'El PIN ingresado es incorrecto o ya ha sido usado.'";
            if ($msg == 3)
                echo "'El PIN ingresado es incorrecto o ya ha sido usado.'";
            if ($msg == 4)
                echo "'¡Pedido realizado! Pronto escucharas tu canción.'";
            if ($msg == 5)
                echo "'La canción ya existente en la playlist, elige otra.'";
        ?> 
        , 8000, 
        <?php 
            if ($msg == 1 || $msg == 4)
                echo "'lime black-text'";
            if ($msg == 2 || $msg == 3 || $msg == 5)
                echo "'red white-text'";
        ?> 
            );
        });
    </script>
    <?php 
        }
    }
    ?>
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
            <li><a href="client.php" class="btn-floating btn-floating-option blue"><i class="material-icons">navigate_before</i></a></li>
        </ul>
    </div>
<!--Scripts-->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/multiselect.min.js"></script>
    <script type="text/javascript">
        var vector_bebidas = 0;        
        $(document).ready(function(){
            /*$('.add').on('click', function() {
                var options = $('#lstview option:selected').sort().clone();
                $('#lstview_to').append(options);
            });
            $('.addAll').on('click', function() {
                var options = $('select.multiselect1 option').sort().clone();
                $('select.multiselect2').append(options);
            });
            $('.remove').on('click', function() {
                $('select.multiselect2 option:selected').remove();
            });
            $('.removeAll').on('click', function() {
                $('select.multiselect2').empty();
            });*/

            // Can use the change on lsview to display data, on current selected option
            $("#lstview").on('dblclick', function (event) {  
                event.preventDefault();
                //do something
                $(this).prop('disabled', $('#lstview_to option').length >= 4);
                $('#send').prop('disabled', $('#lstview_to option').length == 0);
                
                //
                /*alert("something");
                var options = $('#lstview option:selected').sort().clone();
                $('#lstview_to').append(options);*/
            });
            $("#lstview_to").on('dblclick', function (event) {  
                event.preventDefault();
                //do something
                $("#lstview").prop('disabled', $('#lstview_to option').length >= 4);
                $('#send').prop('disabled', $('#lstview_to option').length == 0);
            });


            $('select').material_select();        
            $('.tabs').tabs();            
            $('ul.tabs').tabs('select_tab', '<?php echo $allowed; $allowed="none"; ?>');
            $('.fixed-action-btn').openFAB();
            $('.fixed-action-btn').closeFAB();

            $('#lstview').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                }
            });

            $('#lstview_rightSelected').click(function(){
                $('#lstview_rightSelected').attr("disabled", $('#lstview_to option').length >= 4);
                $('#lstview').prop('disabled', $('#lstview_to option').length >= 4);
                $('#send').prop('disabled', $('#lstview_to option').length == 0)
            });
            $('#lstview_leftSelected').click(function(){
                $('#lstview_rightSelected').attr("disabled", $('#lstview_to option').length >= 4);
                $('#lstview').prop('disabled', $('#lstview_to option').length >= 4);
                $('#send').prop('disabled', $('#lstview_to option').length == 0)
            });

            $('#send').click(function() {
                vector_bebidas = 0;
                $("#lstview_to option").each(function() {
                    if(vector_bebidas == 0) vector_bebidas= $(this).attr('value');
                    else vector_bebidas= vector_bebidas+','+$(this).attr('value');
                });
            
                $("#pin").load("process_drink_request.php",{variable_js: vector_bebidas, variable_js2: <?php echo $pin; ?>});
                window.location.replace("new_request.php?msg=1");
            });  

            $(document).on('click', '#toast-container .toast', function() {
                $(this).fadeOut(function(){
                $(this).remove();
            });
        });
        });       
    </script>
</body>

