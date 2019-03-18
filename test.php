<?php
include "connection.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.
if(isset($_GET["idtarj"])) { // el dato de temperatu se recibe aquí con GET denominado temperatura, es enviado como parametro en la solicitud que realiza la tarjeta microcontrolada
  $TARJ = $_GET["idtarj"];
  
  $mysqli = new mysqli($host, $user, $pw, $db);
  $sql1 = "SELECT * FROM pines_bebidas";
  $result1 = $mysqli->query($sql1);
  $pos = 0;

  while($row1 = $result1->fetch_assoc()) {      
    if($row1['ID_TARJ'] == $TARJ) break;
    $pos++;
  }

  if($pos > 6) $pos = 6;
  echo $pos;
}
?>