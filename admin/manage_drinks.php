<?php
include(__DIR__ . '/../connection.php');

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

try{

  $db_con = new PDO("mysql:host={$host};dbname={$db}", $user, $pw);
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  echo $e->getMessage();
}
$mysqli = new mysqli($host, $user, $pw, $db);
?>

<body class="white">
    <div class="row">
        <div class="col s12">
        <h5 class="light-green-text left-align" style="margin-top:25px;">Administración de Bebidas</h5>
            <div class="card grey darken-4">
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width tabs-transparent">
                        <li class="tab"><a href="#drinks_request" >Pedidos</a></li>
                        <li class="tab"><a href="#drinks_crud">Agregar</a></li>
                        <li class="tab"><a href="#drinks_list">Administración</a></li>
                        <li class="indicator" style="left: 85px; right: 85px;"></li>
                    </ul>
                </div>
                <div class="card-content grey darken-3 grey-text text-lighten-3" style="min-height:280px;">
            
                    <div id="drinks_request">
                        <table class="responsive-table">
                            <thead>
                            <tr>
                                <th>Prioridad</th>
                                <th>Pedido</th>
                                <!-- Precio-->
                                <th>Mesa</th>
                                <th>Descartar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_requests = "SELECT * FROM pines_bebidas";
                                $result_requests = $mysqli->query($sql_requests);
                                while($row_requests = $result_requests->fetch_array(MYSQLI_NUM)) {
                                    ?>
                                    <tr>
                                    <td><?php echo $row_requests[0];?></td>
                                    <td><?php echo $row_requests[2];?></td>
                                    <td><?php echo $row_requests[3];?></td>
                                    <td><a href="admin/delete_request.php?id=<?php echo $row_requests[0]; ?>">
                                        <i class="material-icons lime-text" style="margin-top:-10px;">cancel</i></a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>                
                    </div>

                    <div id="drinks_crud">
                        <div class="container">
                            <div class="thumbnail">
                                <form method="post" action="admin/upload_drinks.php"  enctype="multipart/form-data">
                                    <div class="row">
                                        <h5>Agregar bebida</h5>
                                        <div class="input-field col s6">
                                            <input id="drink_name" name="drink_name" type="text" class="validate" required>
                                            <label for="drink_name">Bebida</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="price" name="price" type="number" class="validate" required>
                                            <label for="price">Precio</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <div class="file-field input-field">
                                                <div class="btn lime black-text">
                                                    <span class="small">Archivo</span>
                                                    <input type="file" name="image">
                                                </div>
                                                    <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="Submit" class="col s4 btn waves-effect waves-black lime black-text">Agregar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id = "drinks_list">
                        <div class="container">                        
                            <div id="responsive" class="section scrollspy">
                                <div class="row">
                                    <div class="col s12">
                                        <form method="post" action="admin.php?tab=2&#38;subtab=3">
                                            <div class="input-field col s6 m8">
                                                <input id="drink_name_list" name="drink_name_list" type="text" class="validate">
                                                <label for="drink_name_list">Bebida</label>
                                            </div>
                                            <div class="col s6 m4">
                                                <button type="submit" name="SubmitBebida" class="btn waves-effect waves-black lime black-text" style="margin-top: 15px;">Consultar</button>
                                            </div>                                            
                                            <input type="hidden" value="1" name="sent12">
                                        </form>
                                    </div>
                                </div>
                                <h5 class="header">Lista de bebidas</h5>
                                <div class="row">
                                    <div class="col s12">
                                        <table class="responsive-table">
                                            <thead>
                                                <th>Bebida</th>
                                                <th>Precio</th>
                                                <th>Imagen</th>
                                                <th>Eliminar</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['sent12'])) {
                                                $nombre = $_POST['drink_name_list'];
                                                if($nombre == "") $results = $db_con->prepare("SELECT * FROM lista_bebidas ORDER BY id");
                                                else $results = $db_con->prepare("SELECT * FROM lista_bebidas where nombre='$nombre' ORDER BY id");


                                                # code...
                                                }else{
                                                $results = $db_con->prepare("SELECT * FROM lista_bebidas ORDER BY id");
                                                }

                                                $results->execute();
                                                // this while statement displays rows of database table
                                                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['nombre']; ?></td>
                                                    <td><?php echo $row['precio']; ?></td>
                                                    <td><img src="admin/uploads/<?php echo $row['drink_img']; ?>" class="img-rounded" alt="image" style="width:60px" height="60px;"></td>
                                                    <td><a href="admin/delete_drinks.php?id=<?php echo $id; ?>"><i class="material-icons lime-text" style="margin-top:-10px;">cancel</i></a> </td>
                                                </tr>
                                                <?php
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            if ($msg == 6)
            echo "'Bebida agregada correctamente.'";
            if ($msg == 7)
            echo "'La bebida no se agregó correctamente correctamente.'";
            if ($msg == 8)
            echo "'Bebida eliminada correctamente.'";
            if ($msg == 9)
            echo "'Pedido descartado correctamente.'";
            ?>
            , 16000,
            <?php
            if ($msg == 6 || $msg == 8 || $msg == 9)
            echo "'lime black-text'";
            if ($msg == 7)
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
<script type="text/javascript">
$(document).ready(function(){
    $('ul.tabs').tabs('select_tab', 
                <?php 
                if(isset($_GET["subtab"])){
                    $tab = $_GET["subtab"];
                    switch ($tab) {
                        case '1':
                            echo "'drinks_request'";
                            break;
                        case '2':
                            echo "'drinks_crud'";
                            break;
                        case '3':
                            echo "'drinks_list'";
                            break;
                        default:
                            echo "'drinks_request'";
                            break;
                    }
                }
                ?>);
    $(document).on('click', '#toast-container .toast', function() {
        $(this).fadeOut(function(){
        $(this).remove();
        });
    });
});
</script>
