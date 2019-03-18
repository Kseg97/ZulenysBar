<?php

require_once 'connection.php';
$mysqli = new mysqli($host, $user, $pw, $db);
$cancion=$_GET["cancion"];
$sql="INSERT INTO playlist (id_,cancion) VALUES (NULL,'$cancion')";
$result = $mysqli->query($sql);
header("location:list_songs.php?");
?>
