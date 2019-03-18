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

if ((isset($_POST["sent2"]))) {
    $person_name = $_POST["person_name"];
    $person_name = str_replace("ñ","n",$person_name);
    $person_name = str_replace("Ñ","N",$person_name);
    $person_cc = $_POST["person_cc"];
    $user_type = $_POST["user_type"];
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
    $user_password_enc = md5($user_password);
    $person_bd = $_POST["person_bd"];
    $user_email = $_POST["user_email"];
    $person_bd = date("Y-m-d H:i:s", strtotime($person_bd));

    $sqlcon = "SELECT * from usuarios where cedula='$person_cc'";
    $resultcon = $mysqli->query($sqlcon);
    $rowcon = $resultcon->fetch_array(MYSQLI_NUM);
    $numero_filas = $resultcon->num_rows;

    if ($numero_filas > 0) {
        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            Materialize.toast('Usuario no fue creado. Ya existe usuario con la misma cédula.', 8000, 'green white-text');});
            </script>
        <?php
    } else {
        $sql = "INSERT INTO usuarios(tipo_usuario, nombre_persona, cedula, password, activo, user_name, email, fecha_nacimiento) 
        VALUES ('$user_type','$person_name','$person_cc','$user_password_enc','1','$user_name','$user_email','$person_bd')";
        $result2 = $mysqli->query($sql);

        if ($result2 == 1) {
        ?>
            <script type="text/javascript">
            $(document).ready(function() {
                Materialize.toast('Usuario creado correctamente.', 8000, 'green white-text');});
                </script>
        <?php
        } else {
            ?>
            <script type="text/javascript">
            $(document).ready(function() {
                Materialize.toast('Usuario no fue creado. Se presentó un inconveniente.', 8000, 'green white-text');});
                </script>
            <?php
        }
    }
} 
?>
<body class="white">
    <div class="row">
        <div class="col s12">
            <h5 class="light-green-text left-align" style="margin-top:25px;">Administración de Usuarios</h5>
       
            <div class="card grey darken-4">
                <div class="card-tabs">
                    <ul class="tabs tabs-transparent">
                    <li class="tab col s2"><a class="active" href="#list" class="">Lista de usuarios</a></li>
                    <li class="tab col s2"><a href="#new">Crear usuario</a></li>
                    <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                </div>
                <div class="card-content grey darken-3 grey-text text-lighten-3">
                    <div id="list" class="active" style="display: block;">
<!--Lista Usuarios (RUD) -->
<div id="responsive" class="section scrollspy">
    <div class="row">
        <div class="col s12">
            <form action="admin.php?tab=1" method="POST">         
                <div class="input-field col s3">
                    <input id="id_qry" name="id_qry" type="text" class="validate">
                    <label for="id_qry">Cedula</label>
                </div>     
                <div class="input-field col s3">
                    <input id="name_qry" name="name_qry" type="text" class="validate">
                    <label for="name_qry">Nombre</label>
                </div>   
                <div class="input-field col s3">
                    <select name="type_qry">                        
                        <option value=2>Todos los Usuarios</option>
                        <option value=1>Usuarios solo Activos</option>
                        <option value=0>Usuarios solo Inactivos</option>
                    </select>
                    <label>Tipo</label>
                </div>
                <input type="hidden" value="1" name="sent">                
                <div class="col s3">
                    <button class="btn waves-effect waves-light btn-small lime black-text" type="submit" style="margin-top: 15px;">Consultar</button>
                </div>
            </form>
        </div>

        <div class="col s12">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Username</th>
                        <th>Tipo</th>
                        <th>Activo</th>
                        <th>Modificar</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    if ((isset($_POST["sent"]))) {
                        $id_qry = $_POST["id_qry"];
                        $name_qry = $_POST["name_qry"];
                        $type_qry = $_POST["type_qry"];
                        $sql1 = "SELECT * from usuarios order by nombre_persona";
                        if (($id_qry == "") and ($name_qry == "")) {
                            if ($type_qry != "2") $sql1 = "SELECT * from usuarios where activo='$type_qry' order by nombre_persona";
                        }
                        if (($id_qry != "") and ($name_qry == "")) {
                            if ($type_qry == "2") $sql1 = "SELECT * from usuarios where cedula='$id_qry'";
                            else $sql1 = "SELECT * from usuarios where cedula='$id_qry' and activo='$type_qry'";
                        }
                        if (($id_qry == "") and ($name_qry != "")) {
                            if ($type_qry == "2") $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry%' order by nombre_persona";
                            else $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry%' and activo='$type_qry' order by nombre_persona";
                        }
                        if (($id_qry != "") and ($name_qry != "")) {
                            if ($type_qry == "2") $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry%' and cedula='$id_qry'";
                            else $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry%' and cedula='$id_qry' and activo='$type_qry'";
                        }    
                    } else $sql1 = "SELECT * from usuarios order by nombre_persona";
     
                    $result1 = $mysqli->query($sql1);
                    while($row1 = $result1->fetch_array(MYSQLI_NUM)) {                        
                        $id_usr = $row1[0];
                        $id_usr_enc = md5($id_usr);
                        $person_cc = $row1[2];
		                $name_usr  = $row1[1];
          	     	    $user_name = $row1[4];
                        $user_type  = $row1[6];
          	     	    $activo = $row1[7];

          			    if ($activo == 1) $desc_activo = 'check'; 
          			    else $desc_activo = 'clear';

                        $sql3 = "SELECT * from tipo_usuario where id='$user_type'";
                        $result3 = $mysqli->query($sql3);
                        $row3 = $result3->fetch_array(MYSQLI_NUM);
          			    $desc_tipo_usuario = $row3[1];
                ?>
                    <tr>
                        <td><?php echo $person_cc; ?></td>
                        <td><?php echo $name_usr; ?></td>
                        <td><?php echo $user_name; ?></td>
                        <td><?php echo ucwords(strtolower($desc_tipo_usuario)); ?></td>
                        <td><i class="material-icons"><?php echo $desc_activo; ?></i></td>
                        <td><a href="update.php?id=<?php echo $id_usr_enc; ?>">
                        <i class="material-icons light-green-text" style="margin-top:-10px;">chrome_reader_mode</i></a></td>
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
                <div id="new" class="active" style="display: block;">
<!--Crear Nuevo Usuario (C) -->
                    <?php
                    
                    ?>
                        <div class="row">
                            <form action="admin.php?tab=1" method="POST">
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
                                    <input id="user_password" name="user_password" type="password" class="validate" required>
                                    <label for="user_password">Password</label>
                                </div>
                                
                                <div class="input-field col s6">
                                    <input id="user_email" name="user_email" type="email" class="validate" required>
                                    <label for="user_email">Email</label>
                                </div>        
                    
                                <div class="input-field col s6">
                                    <select name="user_type">                        
                                        <?php 	
                                        $sql6 = "SELECT * from tipo_usuario order by id DESC";
                                        $result6 = $mysqli->query($sql6);
                                        while($row6 = $result6->fetch_array(MYSQLI_NUM)) {
                                            $tipo_usuario_con = $row6[0];
                                            $desc_tipo_usuario_con = $row6[1];
                                        ?>   
                                            <option value="<?php echo $tipo_usuario_con; ?>"> <?php echo strtoupper($desc_tipo_usuario_con); ?></option>  
                                        <?php
                                        }
                                        ?>     
                                    </select>
                                    <label>Tipo</label>
                                </div>                          

                                <input type="hidden" value="true" name="sent2">

                                <div class="col s12 right-align">
                                    <button class="btn waves-effect waves-light btn-small lime black-text" type="submit">Registrar</button>
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
        if ($msg == 1)
            echo "'Usuario actualizado correctamente.'";
        if ($msg == 2)
            echo "'Usuario no fue actualizado correctamente.'";
        if ($msg == 3)
            echo "'Usuario creado correctamente.'";
        if ($msg == 4)
            echo "'Usuario no fue creado. Se presentó un inconveniente.'";
        if ($msg == 5)
            echo "'Usuario no fue creado. Ya existe usuario con la misma cédula.'";
    ?> 
    , 16000, 
    <?php 
        if ($msg == 1)
            echo "'lime black-text'";
        if ($msg == 2)
            echo "'red white-text'";
        if ($msg == 3)
            echo "'lime black-text'";
        if ($msg == 4)
            echo "'red white-text'";
        if ($msg == 5)
            echo "'red white-text darken-2'";
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
        $('select').material_select();

        $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 50, // Creates a dropdown of 15 years to control year,
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true // Close upon selecting a date,
            });
    });       
</script>