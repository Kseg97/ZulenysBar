<?php
include "connection.php";

session_start();


if(isset($_SESSION["auth"])) {
    if($_SESSION["auth"] == "SIx3") {
        $mysqli = new mysqli($host, $user, $pw, $db);
        $sqlusu = "SELECT * from tipo_usuario where id='2'";
        $resultusu = $mysqli->query($sqlusu);
        $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
        $desc_tipo_usuario = $rowusu[1];
        if ($_SESSION["user_type"] != $desc_tipo_usuario)
        header('Location: admin.php');
    } else header('Location: index.php');
    } else header('Location: index.php');


if ((isset($_POST["sent_profile"]))) {
    $id_user = $_POST["id_usr"];

    $old_password = $_POST["old_pswd"];
    $old_password_enc = md5($old_password);
    $sqlenc = "SELECT * from usuarios where id='$id_user'";
    $resultenc = $mysqli->query($sqlenc);
    $rowenc = $resultenc->fetch_array(MYSQLI_NUM);
    $current_password = $rowenc[5];
    if ($current_password == $old_password_enc) {
        $password = $_POST["new_pswd"];

        if ($password != "") {
            $password_enc = md5($password);
            $sqlu9 = "UPDATE usuarios set password='$password_enc' where id='$id_user'"; 
            $resultsqlu9 = $mysqli->query($sqlu9);
        }  
    
        if ($resultsqlu9 == 1)
            header('Location: client.php?tab=1&msg=1');
        else
            header('Location: client.php?tab=1&msg=2'); 
    } else header('Location: client.php?tab=1&msg=3'); 
} 
?>