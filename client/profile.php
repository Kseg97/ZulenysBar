<?php
include "connection.php";

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

$user_id = $_SESSION["user_id"];
$sql_profile = "SELECT * FROM usuarios where id='$user_id'";
$result_profile = $mysqli->query($sql_profile);
$row_profile = $result_profile->fetch_array(MYSQLI_NUM);
?>
<div class="row">
    <div class="col s12 m10 offset-m1">
        <div class="card-panel lime lighten-4 black-text">
            <div class="row">
                <div class="col s4">
                    <i class="material-icons lime-text" style="display:flex; justify-content:center;font-size: 30vw">account_circle</i>
                </div>
                
                <div class="col s7 offset-s1">
                    <h6><b>NOMBRE:</b> <?php echo strtoupper($row_profile[1]); ?></h6>                
                    <h6 class="grey-text ">CLIENTE</h6>
                    <br>
                    <h6><b>CEDULA:</b> <?php echo $row_profile[2]; ?></h6>
                    <h6><b>FECHA DE NACIMIENTO:</b> <?php echo $row_profile[3]; ?></h6>
                    <h6><b>USUARIO:</b> <?php echo $row_profile[4]; ?></h6>
                    <h6><b>EMAIL:</b> <?php echo $row_profile[8]; ?></h6>

                    <br>
                    <!-- Modal Trigger -->
                    <a class="waves-effect lime waves-black btn modal-trigger black-text" href="#modal_profile">CAMBIAR CONTRASEÑA</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal_profile" class="modal bottom-sheet">
    <div class="modal-content grey darken-4 white-text">
        <form action="update_password.php" method="post">
            <h5>Cambio de contraseña</h5>
            <hr>
            <div class="row">
                <div class="input-field col s6">
                    <input id="old_pswd" name="old_pswd" type="password" class="validate" required>
                    <label for="old_pswd">CONTRASEÑA ACTUAL</label>
                </div>
                <div class="input-field col s6">
                    <input id="new_pswd" name="new_pswd" type="password" class="validate" required>
                    <label for="new_pswd">CONTRAEÑA NUEVA</label>
                </div>
                <input type="hidden" value="<?php echo $user_id; ?>" name="id_usr">
                <input type="hidden" name="sent_profile">
                <div class="input-field col s12 right-align">
                    <button class="btn waves-effect waves-light lime black-text right-align"> MODIFICAR</button>
                </div>
            </div>
        </form>
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
            echo "'Contraseña actualizada correctamente.'";
        if ($msg == 2)
            echo "'Contraseña no fue actualizada correctamente.'";
        if ($msg == 3)
            echo "'La contraseña actual introducida en el sistema es incorrecta.'";
    ?> 
    , 16000, 
    <?php 
        if ($msg == 1)
            echo "'lime black-text'";
        if ($msg == 2 || $msg == 3)
            echo "'red white-text'";
    ?> 
        );
    });
</script>
<?php 
    }
}
?>


  <script type="text/javascript">        
  $(document).ready(function(){
    $(document).on('click', '#toast-container .toast', function() {
            $(this).fadeOut(function(){
            $(this).remove();
            });
        });
    $('.modal').modal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      inDuration: 300, // Transition in duration
      outDuration: 200, // Transition out duration
      startingTop: '34%', // Starting top style attribute
      endingTop: '40%', // Ending top style attribute
      /*ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
        alert("Ready");
        console.log(modal, trigger);
      },
      complete: function() { alert('Closed'); } // Callback for Modal close*/
    }
  );
  });      
</script>