<?php

require_once 'connection.php';
$mysqli = new mysqli($host, $user, $pw, $db);

$sql= "SELECT * FROM lista_canciones";
$result = $mysqli->query($sql);


 ?>

<html>
  <head>
    <title>Zuleny's Bar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container">
      <h1>List Users</h1>
      <a href="list_songs.php">Home</a>
      <table class="table">
        <tr>
          <th>Nombre</th>
          <th>Genero</th>
          <th>Seleccionar</th>
        </tr>
        <?php
        while($row = $result->fetch_assoc()){
          echo '<tr>';
          echo '<td>'.$row['cancion'].'</td>';
          echo '<td>'.$row['genre'].'</td>';
          echo '<td><a href="update_playlist.php?cancion=' .$row['cancion'].'">Seleccionar</a></td>';
          echo '</tr>';
        }

         ?>
      </table>
    </div>
  </body>
</html>
