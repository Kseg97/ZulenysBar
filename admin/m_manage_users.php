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
?>
<body class="white">
    <div class="row">
        <div class="col s12">
            <h5 class="light-green-text left-align" style="margin-top:25px;">Administración de Usuarios</h5>
       
            <div class="card grey darken-4">
                <div class="card-tabs">
                    <ul class="tabs tabs-transparent">
                    <li class="tab col s2"><a class="active" href="#list1" class="">Lista de usuarios</a></li>
                    <li class="tab col s2"><a href="#new1">Crear usuario</a></li>
                    <li class="indicator" style="left: 85px; right: 85px;"></li></ul>
                </div>
                <div class="card-content grey darken-3 grey-text text-lighten-3">
                    <div id="list1" class="active" style="display: block;">
<!--Lista Usuarios (RUD) -->
<div id="responsive" class="section scrollspy">
    <div class="row">
        <div class="col s12">
            <form action="admin.php?tab=1" method="POST">         
                <div class="input-field col s6">
                    <input id="id_qry3" name="id_qry3" type="number" class="validate">
                    <label for="id_qry3">Cedula</label>
                </div>     
                <div class="input-field col s6">
                    <input id="name_qry3" name="name_qry3" type="text" class="validate">
                    <label for="name_qry3">Nombre</label>
                </div>   
                <div class="input-field col s6">
                    <select name="type_qry3">                        
                        <option value=2>Todos los Usuarios</option>
                        <option value=1>Usuarios solo Activos</option>
                        <option value=0>Usuarios solo Inactivos</option>
                    </select>
                    <label>Materialize Select</label>
                </div>
                <input type="hidden" value="1" name="sent3">                
                <div class="col s6">
                    <button class="btn waves-effect waves-light btn-small lime" type="submit" style="margin-top: 15px;">Consultar</button>
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
                    if ((isset($_POST["sent3"]))) {
                        $id_qry3 = $_POST["id_qry3"];
                        $name_qry3 = $_POST["name_qry3"];
                        $type_qry3 = $_POST["type_qry3"];
                        $sql1 = "SELECT * from usuarios order by nombre_persona";
                        if (($id_qry3 == "") and ($name_qry3 == "")) {
                            if ($type_qry3 != "2") $sql1 = "SELECT * from usuarios where activo='$type_qry3' order by nombre_persona";
                        }
                        if (($id_qry3 != "") and ($name_qry3 == "")) {
                            if ($type_qry3 == "2") $sql1 = "SELECT * from usuarios where cedula='$id_qry3'";
                            else $sql1 = "SELECT * from usuarios where cedula='$id_qry3' and activo='$type_qry3'";
                        }
                        if (($id_qry3 == "") and ($name_qry3 != "")) {
                            if ($type_qry3 == "2") $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry3%' order by nombre_persona";
                            else $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry3%' and activo='$type_qry3' order by nombre_persona";
                        }
                        if (($id_qry3 != "") and ($name_qry3 != "")) {
                            if ($type_qry3 == "2") $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry3%' and cedula='$id_qry3'";
                            else $sql1 = "SELECT * from usuarios where nombre_persona LIKE '%$name_qry3%' and cedula='$id_qry3' and activo='$type_qry3'";
                        }    
                    } else $sql1 = "SELECT * from usuarios order by nombre_persona";
     
                    $result1 = $mysqli->query($sql1);
                    while($row1 = $result1->fetch_array(MYSQLI_NUM)) {                        
                        $id_usr = $row1[0];
                        $id_usr_enc = md5($id_usr);
                        $person_cc = $row1[2];
		                $name_usr  = $row1[1];
          	     	    $user_name3 = $row1[4];
                        $user_type3  = $row1[6];
          	     	    $activo = $row1[7];

          			    if ($activo == 1) $desc_activo = 'check'; 
          			    else $desc_activo = 'clear';

                        $sql3 = "SELECT * from tipo_usuario where id='$user_type3'";
                        $result3 = $mysqli->query($sql3);
                        $row3 = $result3->fetch_array(MYSQLI_NUM);
          			    $desc_tipo_usuario = $row3[1];
                ?>
                    <tr>
                        <td><?php echo $person_cc; ?></td>
                        <td><?php echo $name_usr; ?></td>
                        <td><?php echo $user_name3; ?></td>
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
                <div id="new1" class="active" style="display: block;">
<!--Crear Nuevo Usuario (C) -->
                    <?php
                    if ((isset($_POST["sent32"]))) {
                        $person_name3 = $_POST["person_name3"];
                        $person_name3 = str_replace("ñ","n",$person_name3);
                        $person_name3 = str_replace("Ñ","N",$person_name3);
                        $person_cc3 = $_POST["person_cc3"];
                        $user_type3 = $_POST["user_type3"];
                        $user_name3 = $_POST["user_name3"];
                        $user_password3 = $_POST["user_password3"];
                        $user_password3_enc = md5($user_password3);
                        $person_bd3 = $_POST["person_bd3"];
                        $user_email3 = $_POST["user_email3"];
                        $person_bd3 = date("Y-m-d H:i:s", strtotime($person_bd3));

                        $sqlcon = "SELECT * from usuarios where cedula='$person_cc3'";
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
                            $sql = "INSERT INTO usuarios(tipo_usuario, nombre_persona, cedula, password, activo, user_name3, email, fecha_nacimiento) 
                            VALUES ('$user_type3','$person_name3','$person_cc3','$user_password3_enc','1','$user_name3','$user_email3','$person_bd3')";
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
                                    Materialize.toast('Usuario no fue creado. Se present3ó un inconveniente.', 8000, 'green white-text');});
                                    </script>
                                <?php
                            }
                        }
                    } 
                    ?>
                        <div class="row">
                            <form action="admin.php?tab=1" method="POST">
                                <div class="input-field col s12">
                                    <input id="person_name3" name="person_name3" type="text" class="validate" required>
                                    <label for="person_name3">Nombre Completo</label>
                                </div>

                                <div class="input-field col s6">
                                    <input id="person_cc3" name="person_cc3" type="number" class="validate" required>
                                    <label for="person_cc3">Cédula</label>
                                </div>

                                <div class="input-field col s6">
                                    <input id="person_bd3" name="person_bd3" type="text" class="datepicker" step="1" name="fecha_nac" required="" aria-required="true">
                                    <label for="person_bd3">Fecha de nacimiento</label>
                                </div>

                                <div class="input-field col s6">
                                    <input id="user_name3" name="user_name3" type="text" class="validate" required>
                                    <label for="user_name3">Username</label>
                                </div>

                                <div class="input-field col s6">
                                    <input id="user_password3" name="user_password3" type="password" class="validate" required>
                                    <label for="user_password3">Password</label>
                                </div>
                                
                                <div class="input-field col s6">
                                    <input id="user_email3" name="user_email3" type="email" class="validate" required>
                                    <label for="user_email3">Email</label>
                                </div>        
                    
                                <div class="input-field col s6">
                                    <select name="user_type3">                        
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

                                <input type="hidden" value="true" name="sent32">

                                <div class="col s12 right-align">
                                    <button class="btn waves-effect waves-light btn-small lime" type="submit">Registrar</button>
                                </div>
                            </form>
                        </div>
<!--Fin-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript">        
    $(document).ready(function(){
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