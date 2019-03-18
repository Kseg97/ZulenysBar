<?php
 include "connection.php";
 $mysqli = new mysqli($host, $user, $pw, $db);
 $played_song = htmlspecialchars($_POST['song']);

 $sqlStr = "DELETE FROM playlist LIMIT 1";
 $mysqli->query($sqlStr);
 ?>
