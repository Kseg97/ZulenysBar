<?php
include "connection.php";
$mysqli = new mysqli($host, $user, $pw, $db); 

    $vector_bebidas = $_REQUEST['variable_js'];
    $pin = $_REQUEST['variable_js2'];

    $sql_mesa = "SELECT * FROM lista_pines where pin='$pin'";
    $result_mesa = $mysqli->query($sql_mesa);
    $row_mesa = $result_mesa->fetch_array(MYSQLI_NUM);

    $sql2 = "INSERT INTO pines_bebidas (nombre, pin, ID_TARJ) VALUES ('$vector_bebidas', $pin, $row_mesa[2])";
    $result2 = $mysqli->query($sql2);

    $sql_del = "DELETE FROM lista_pines where pin='$pin'";
    $result_del = $mysqli->query($sql_del);

    header("Location: new_request.php?msg=1");
?>