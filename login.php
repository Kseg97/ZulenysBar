<?php                                               
$login = $_POST["login1"];
$passwd = $_POST["passwd1"];

$passwd_comp = md5($passwd);
session_start();

include ("connection.php");

$mysqli = new mysqli($host, $user, $pw, $db);
       
$sql = "SELECT * from usuarios where user_name = '$login' and activo='1'";
$result1 = $mysqli->query($sql);
$row1 = $result1->fetch_array(MYSQLI_NUM);
$numero_filas = $result1->num_rows;

sleep(2);

if ($numero_filas > 0) {
  $passwdc = $row1[5];
  if ($passwdc == $passwd_comp) {
      $_SESSION["auth"] = "SIx3";
      $user_type = $row1[6];
      $person_name = $row1[1];
      $sql2 = "SELECT * from tipo_usuario where id='$user_type'";
      $result2 = $mysqli->query($sql2);
      $row2 = $result2->fetch_array(MYSQLI_NUM);
      $list_user_type = $row2[1];
      $_SESSION["user_type"]= $list_user_type;
      $_SESSION["person_name"]= $person_name;  
      $_SESSION["user_id"]= $row1[0];;  
      
      if ($user_type == 1)
        header("Location: admin.php");
      else
        header("Location: client.php");
  } else {
    header('Location: index.php?msg=1');
  }
} else {
  header('Location: index.php?msg=2');
}  
?>
