<?php
  session_start();
  unset($_SESSION["person_name"]); 
  unset($_SESSION["user_type"]);
  unset($_SESSION["auth"]);
  session_destroy();
  header('Location: index.php?msg=6');
?>
