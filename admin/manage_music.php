<?php
include(__DIR__ . '/../connection.php');


if(!isset($_SESSION))
    session_start();

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

if ((isset($_POST["sent32"]))) {
    $genre = $_POST["genre"];
    $sqlgenre = "INSERT INTO `genero_canciones` (`id`, `genero`) VALUES (NULL, '$genre')";
    $result1 = $mysqli->query($sqlgenre);
    if ($result1 == 1) echo "<script>window.location.replace('admin.php?tab=3&subtab=2&msg=13');</script>";
    else echo "<script>window.location.replace('admin.php?tab=3&subtab=3&msg=14');</script>";
}
?>
<body class="white">
    <div class="row">
        <div class="col s12">
            <h5 class="light-green-text left-align" style="margin-top:25px;">Administración de Canciones</h5>

            <div class="card grey darken-4">
                <div class="card-tabs">
                    <ul class="tabs tabs-transparent">
                    <li class="tab col s2"><a class="active" href="#list_song" class="">Lista de canciones</a></li>
                    <li class="tab col s2"><a href="#new_song">Agregar cancion</a></li>
                    <li class="tab col s2"><a href="#new_genre">Agregar género</a></li>
                    <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                </div>
                <div class="card-content grey darken-3 grey-text text-lighten-3">
                    <div id="list_song" class="active" style="display: block;">
<!--Lista Canciones (RUD) -->
<div id="responsive" class="section scrollspy">
    <div class="row">
        <div class="col s12">
            <form action="admin.php?tab=3" method="POST">                
                <div class="input-field col s3">
                    <input id="cancion_name" name="cancion_name" type="text" class="validate">
                    <label for="cancion_name">Nombre</label>
                </div>

                <!--<div class="input-field col s3">
                    <input id="cancion_genre" name="cancion_genre" type="text" class="validate">
                    <label for="cancion_genre">Género</label>
                </div>-->
                <div class="input-field col s3">
                    <select name="cancion_genre"> 
                        <option value=0>Todos los Géneros</option>
                        <?php   
                            $sql_genre = "SELECT * from genero_canciones";
                            $result_genre = $mysqli->query($sql_genre);
                            while($row_genre = $result_genre->fetch_array(MYSQLI_NUM)){                     
                                echo "<option value=$row_genre[0]>$row_genre[1]</option>";
                            }
                        ?>
                    </select>
                    <label>Género</label>
                </div>

                <input type="hidden" value="1" name="sent12">
                <div class="col s3">
                    <button class="btn waves-effect waves-light btn-small lime black-text" type="submit" style="margin-top: 15px;">Consultar</button>
                </div>
            </form>
            <form action="../bar/player/index.php" target="_blank">
                <div class="col s3" >
                    <button class="btn waves-effect waves-light btn-small lime black-text" type="submit" style="margin-top: 15px;">Ir al reproductor</button>
                </div>
            </form>
        </div>

        <div class="col s12">
            <table class="responsive-table">
                <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Género</th>
                      <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    if ((isset($_POST["sent12"]))) {
                      $cancion_genre = $_POST["cancion_genre"];
                      $cancion_name = $_POST["cancion_name"];

                      $sql1 = "SELECT * from lista_canciones order by id_cancion";
                      if (($cancion_genre == "0") and ($cancion_name == "")) {
                          $sql1 = "SELECT * from lista_canciones ";
                      }
                      if (($cancion_genre != "0") and ($cancion_name == "")) {
                           $sql1 = "SELECT * from lista_canciones where genre='$cancion_genre'";

                      }
                      if (($cancion_genre == "0") and ($cancion_name != "")) {
                          $sql1 = "SELECT * from lista_canciones where cancion LIKE '%$cancion_name%' order by id_cancion";

                      }
                      if (($cancion_genre != "0") and ($cancion_name != "")) {
                          $sql1 = "SELECT * from lista_canciones where cancion LIKE '%$cancion_name%' and genre='$cancion_genre'";

                      }
                  } else $sql1 = "SELECT * from lista_canciones order by id_cancion";

                  $result1 = $mysqli->query($sql1);
                  while($row1 = $result1->fetch_assoc()) {
                     $genero = $row1['genre'];
                    $gener_name = $row1['cancion'];
                    $id=$row1['id_cancion'];
                ?>
                    <tr>
                        <td><?php echo $gener_name; ?></td>
                        <td>
                            <?php 
                                $sql_genre_id = "SELECT * from genero_canciones where id='$genero'";
                                $result_genre_id = $mysqli->query($sql_genre_id);
                                $row_genre_id = $result_genre_id->fetch_array();
                                echo $row_genre_id[1]; 
                            ?>
                        </td>
                        <td><a href="admin/delete_music.php?id=<?php echo $id; ?>">
                        <i class="material-icons lime-text" style="margin-top:-10px;">cancel</i></a></td> </tr>
                    </tr>
                <?php
                    }
                ?>
              </tbody>
            </table>
        </div>
    </div>
</div>
<!--Fin-->
                    </div>
                    <div id="new_song" style="display: block;">
    <!--añadir cancion (C) -->                        
                        <div class="row">
                            <form method="POST" action="admin/upload_songs.php"  enctype="multipart/form-data">
                                <div class="input-field col s5">
                                    <select name="song_gen"> 
                                        <?php   
                                            $sql_genre = "SELECT * from genero_canciones";
                                            $result_genre = $mysqli->query($sql_genre);
                                            while($row_genre = $result_genre->fetch_array(MYSQLI_NUM)){                     
                                                echo "<option value=$row_genre[0]>$row_genre[1]</option>";
                                            }
                                        ?>
                                    </select>
                                    <label>Género</label>
                                </div>
                                <div class="input-field col s7">
                                    <div class="file-field input-field">
                                    <div class="btn lime black-text">
                                        <span class="small">Archivo*</span>
                                        <input type="file" name="song">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                    </div>
                                </div>

                                <div class="col s8 center-align">
                                    <h6 class="lime-text">*El nombre de la canción es tomado del nombre del archivo</h6>
                                </div>

                                <div class="col s4 right-align">
                                    <button class="btn waves-effect waves-light btn-small lime black-text" name="Submit" type="submit">Agregar</button>
                                </div>                               
                            </form>
                        </div>
<!--Fin-->
                    </div>
                    <div id="new_genre" style="display: block;">
    <!--añadir genero (C) -->                        
                        <div class="row">
                            <form method="POST" action="admin.php?tab=3">
                                <div class="input-field col s8">
                                    <input id="genre" name="genre" type="text" class="validate">
                                    <label for="genre">Género</label>
                                </div>                
                
                                <input type="hidden" value="1" name="sent32">
                                <div class="col s4">
                                    <button class="btn waves-effect waves-light btn-small lime black-text" type="submit" style="margin-top: 15px;">Agregar</button>
                                </div>
                            </form>
                        </div>
<!--Fin-->
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        if ($msg == 10)
            echo "'Canción agregada correctamente.'";
        if ($msg == 11)
            echo "'Canción no agregada. Se presentó un inconveniente.'";
        if ($msg == 12)
            echo "'Canción ya agregada. Ya existe canción con el mismo título.'";
        if ($msg == 13)
            echo "'Género agregado correctamente.'";
        if ($msg == 14)
            echo "'Género no agregado. Se presentó un inconveniente.'";
    ?>
    , 16000,
    <?php
        if ($msg == 10 || $msg == 13)
            echo "'lime black-text'";
        if ($msg == 11 || $msg == 14)
            echo "'red white-text'";
        if ($msg == 12)
            echo "'red white-text'";
    ?>
        );
    });
</script>
<?php
    }
}
?>
</body>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#toast-container .toast', function() {
            $(this).fadeOut(function(){
            $(this).remove();
            });
        });
        $('.tabs').tabs();
        $('ul.tabs').tabs('select_tab', 
                <?php 
                if(isset($_GET["subtab"])){
                    $tab = $_GET["subtab"];
                    switch ($tab) {
                        case '1':
                            echo "'list_song'";
                            break;
                        case '2':
                            echo "'new_song'";
                            break;
                        case '3':
                            echo "'new_genre'";
                            break;
                        default:
                            echo "'list_song'";
                            break;
                    }
                }
                ?>);
        $('select').material_select();
    });
</script>
