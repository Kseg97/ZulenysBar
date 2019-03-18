<?php
include(__DIR__ . '/../connection.php');

$pin = $_GET["pin"];
$ID_TARJ = $_GET["ID_TARJ"];

$mysqli = new mysqli($host, $user, $pw, $db); 
$sql1 = "INSERT into lista_pines (pin, ID_TARJ) VALUES ('$pin', '$ID_TARJ')"; // Aquí se ingresa el valor recibido a la base de datos.
echo "sql1...".$sql1; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de algún error.
$result1 = $mysqli->query($sql1);
echo "result es...".$result1; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.

?>