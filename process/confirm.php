<?php
include(__DIR__ . '/../connection.php');
if(isset($_GET["idtarj"])) { 
  $TARJ = $_GET["idtarj"];
  
  $mysqli = new mysqli($host, $user, $pw, $db);
  $sql1 = "SELECT * FROM pines_bebidas";
  $result1 = $mysqli->query($sql1);
  $pos = 1;
  $cnt = 1;
//
  while($row1 = $result1->fetch_assoc()) {
    $cnt++;      
    if($row1['ID_TARJ'] == $TARJ) { break;}
    $pos++;
  }
  if($cnt == $pos) $pos=0;

  if($pos > 6) $pos = 6;
  echo $pos;
}
?>