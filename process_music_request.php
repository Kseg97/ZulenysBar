<?php
include "connection.php";
$mysqli = new mysqli($host, $user, $pw, $db);

if(isset($_GET["id"]) && isset($_GET["pin"])) {
    $id = $_GET["id"];
    $pin = $_GET["pin"];

    $sql_song = "SELECT * FROM lista_canciones where id_cancion='$id'";
    $result_song = $mysqli->query($sql_song);
    $row_song = $result_song->fetch_array(MYSQLI_NUM);

    $chckIfSongIsInQueue = "SELECT cancion FROM playlist where id_cancion = '$id' "; //TODO poner limit = 30
    $result_chck = $mysqli->query($chckIfSongIsInQueue);
    if (!$result_chck ->num_rows == 0 ){
        header("Location: new_request.php?msg=5");

    } else {
        $sql2 = "INSERT INTO playlist (cancion, id_cancion) VALUES ('$row_song[1]', $row_song[0])";
        $result2 = $mysqli->query($sql2);

        $sql_del = "DELETE FROM lista_pines where pin='$pin'";
        $result_del = $mysqli->query($sql_del);

        header("Location: new_request.php?msg=4");
    }
}
?>