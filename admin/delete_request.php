<?php
include(__DIR__ . '/../connection.php'); 
$mysqli = new mysqli($host, $user, $pw, $db);

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql_del = "DELETE FROM pines_bebidas where id='$id'";
    $result_del = $mysqli->query($sql_del);
    //REORDER
    $mysqli->query("SET @var:=0;");
    $mysqli->query("UPDATE pines_bebidas SET id=(@var:=@var+1);");
    $mysqli->query("ALTER TABLE pines_bebidas AUTO_INCREMENT=1;");
    
    header("Location: ../admin.php?tab=2&msg=9");
}
?>