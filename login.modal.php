<!-- Login Dialog -->
    <div id="login" class="modal">
      <div class="container"> 
        <div class="modal-content">
          <h5 class="grey-text left-align" style="margin-top:25px;">Ingresar </h5>
          <hr>
          <form class="cols12" id="form" method="post" action="login.php">
            <div class="row">
              <div class="input-field col s12">
                <input id="login1" name="login1" type="text" class="validate" required="" aria-required="true">
                <label for="login1">Usuario</label>
              </div>

              <div class="input-field col s12">
                <input id="pass_input" name="passwd1" type="password" class="validate" required="" aria-required="true">
                <label for="pass_input">Contraseña</label>
              </div>
            </div> 

            <div class="row right-align">
              <button class="btn waves-effect waves-light btn-small light-green" type="submit" name="submit" id="connect">Ingresar</button>
            </div>

            <div class="row center-align">
              <h6 class="grey-text">Si no tienes una cuenta <a href="signup.php" class="lime-text">Resgístrate</a></h6>
            </div>
          </form> 

          <div id="snipper" class="progress lime">
            <div class="indeterminate light-green"></div>
          </div>      
        </div>
      </div>
    </div>
    <!--Scripts-->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.modal').modal();

        $('#snipper').hide(); 

        $('form').submit(function(){
          $('#snipper').show();
          $('#form').hide();
          $('#connect').hide();       
        });
      });       
    </script>