<?php
 include "connection.php";
//TODO: user_id sacarlo de playlist, daza tiene que ponerle el id
 //OJO, no pueden existir dos items con el mismo id_cancion

 $mysqli = new mysqli($host, $user, $pw, $db);

 $played_song = htmlspecialchars($_POST['current_playing']);
 $month = htmlspecialchars($_POST['month']);
 $minutes = htmlspecialchars($_POST['minutes']);
 $hour = htmlspecialchars($_POST['hour']);
 $day= htmlspecialchars($_POST['day']);
 $year = htmlspecialchars($_POST['year']);
 $uid = htmlspecialchars($_POST['uid']);
 $seconds = htmlspecialchars($_POST['seconds']);

 session_start();
if(isset($_SESSION["user_id"])) {
    $uid = $_SESSION["user_id"];
}


// $date = htmlspecialchars($_POST['date']);
 //v2
 $date = '2018-'.$month.'-'.$day.' '.$hour.':'.$minutes.':'.$seconds;
 $cancion = $played_song;
//$date = ''
 //$date  = date("Y-m-d H:i:s", $final);
//end v2
 //$cancion = $played_song;
 //$cancion = 'Diablita.m3'; //Problema si no encuentra el nombre
 $chckStr = "SELECT cancion From est_canciones_genre WHERE cancion = '$cancion'";

 $result = $mysqli ->query($chckStr);
 $counter = 0;
 $id = 0;
 $genre = 0; //genero por default todo:
 //Get Genre
$getGenre = "SELECT genre, id_cancion FROM lista_canciones WHERE cancion = '$cancion'";
$resultGenre = $mysqli -> query($getGenre);
if (!$resultGenre ->num_rows == 0){
  echo "Encontrado En la base de datos";
while ($fila = $resultGenre -> fetch_array() ) {
  $genre= $fila['genre'];
  $id = $fila['id_cancion'];}
  # code...
}else {

  echo "NO Encontrado En la base de datos";

}

//

  if($result->num_rows ==0){
   echo "NO existe";
   $counter = 0;

  }else {
    $sqlCounter = "SELECT counter FROM est_canciones_genre where cancion = '$cancion' ";

    $result1 = $mysqli->query($sqlCounter);
    while ($row = $result1 -> fetch_assoc()) {
     $counter = $row['counter'];
     # code...
     echo "existe";
   }


  }

$counter = $counter + 1;
//"UPDATE temperatura_maxima set minimo = '$min', maximo = '$max' WHERE id = 0 ";
 //$sqlStr = "INSERT INTO est_canciones_genre (id_cancion,cancion,fecha, counter) WHERE cancion = '$cancion' VALUES (1, '$played_song', '$date', $counter)";

 if($result->num_rows ==0){
   $sqlStr = "INSERT INTO est_canciones_genre (id_cancion, cancion,fecha, counter, genre) VALUES ('$id','$cancion', '$date', '$counter', '$genre')";
   echo "No existe en est_canciones_genre, creando el nuevo item";
   $mysqli->query($sqlStr);



 }else{
   $sqlStr = "UPDATE est_canciones_genre set cancion = '$cancion', counter = '$counter' where cancion = '$cancion'";
   echo "Existe en est_canciones_genre, actualizando....";
   $mysqli->query($sqlStr);

 }
 //Insertar en est_canciones_hist

 $strHist = "INSERT INTO est_canciones_hist (id, cancion, user_id, fecha) VALUES ( '$id', '$cancion', '$uid', '$date') ";
 $mysqli->query($strHist);


 ?>
