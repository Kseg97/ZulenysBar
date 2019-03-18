<?php
include(__DIR__ . '/../connection.php');

session_start();

if (!isset($_GET["id"]))
    header('Location: admin.php?tab=1');

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
$mysqli = new mysqli($host, $user, $pw, $db);
$id=$_GET["id"];
$sql = "DELETE FROM lista_canciones WHERE id_cancion = $id";
$result = $mysqli->query($sql);
header("Location: ../admin.php?tab=3");

?>
