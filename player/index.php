<!DOCTYPE html>
<html>
<?php
include "connection.php";
$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
$sql1 = "SELECT * FROM playlist";
$result1 = $mysqli -> query($sql1);
?>
<head lang="en">
	<meta charset="UTF-8">
	<title>HTML5 Music Player</title>
	<link href='assets/css/styles.css' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="assets/css/font-awesome-4.3.0/css/font-awesome.min.css">
	<link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon" />
</head>
<body>

<div id="container" class="disabled">

	<div id="cover-art">
		<div id="cover-art-big"></div>
		<img id="cover-art-small" alt="cover-art-small" src="assets/img/default.png">
		<div class="instructions">Drop your audio files here.</div>
	</div>

	<div id="wave"></div>

	<div id="control-bar">

		<div class="player-control">
			<div id="previous-button" title="Previous"><i class="fa fa-fast-backward"></i></div>
			<div id="play-button" title="Play"><i class="fa fa-play"></i></div>
			<div id="pause-button" title="Pause"><i class="fa fa-pause"></i></div>
			<div id="stop-button" title="Stop"><i class="fa fa-stop"></i></div>
			<div id="next-button" title="Next"><i class="fa fa-fast-forward"></i></div>
			<div id="shuffle-button" title="Shuffle Off"><i class="fa fa-random"></i></div>
			<div id="repeat-button" title="Repeat Off"><i class="fa fa-refresh"><span>1</span></i></div>
		</div>

		<div id="playlist">

			<div id="track-details" title="Show playlist">
				<i class="fa fa-sort"></i>
				<p id="track-desc">There are no tracks loaded in the player.</p>
				<p id="track-time">
					<span id="current">-</span> / <span id="total">-</span>
				</p>
			</div>

			<div id="expand-bar" class="hidden">

				<form>
					<label for="searchBox">Search</label><div><input id="searchBox" type="search" name="search"></div>
				</form>
				<ul id="list"></ul>
			</div>

		</div>

	</div>

	<div id="drop-zone" class="hidden">Drag &amp; Drop Files Here</div>
	<ol id="playlistBD" class="playlist hidden">
		<!--
		TODO: hacer las peticiones con php
		<li audiourl="Diablita.mpe"></li>
		playlist se guarda el nombre + mp3
		ejemplo cancion.mp3

	-->
		<?php
		$counter = 0;
		 while ($row = $result1 -> fetch_assoc()) {?>
			<li style = "display:none;" audiourl="<?php echo $row['cancion'];?>" userid="<?php echo $counter;?>"></li>
			<?php
			$counter = $counter + 1;
			echo $counter;
		 } ?>
	</ol>

	<?php //Fragmento para añadir canciones cuando sea menos de 5 items
	$getNumbersOfRows = "SELECT id_ FROM playlist";
	$resultRows = $mysqli -> query($getNumbersOfRows);
	$number = $resultRows ->num_rows;
	if($number < 4){
		//Recuperar id_s canciones y cancion y  añadir a playlist
		$getInfo = "SELECT cancion FROM lista_canciones";

		$canciones = array();
		$resultSong = $mysqli -> query($getInfo);
		while ($fila = $resultSong -> fetch_assoc()) {
			array_push($canciones, $fila['cancion']);
		}
		$aleatorias = shuffle($canciones);
		foreach ($canciones as $numero) {
		$getId_cancion = "SELECT id_cancion FROM lista_canciones WHERE cancion = '$numero'";
		$resultSong = $mysqli -> query($getId_cancion);

		while ($rowID= $resultSong -> fetch_assoc()) {
			# code...
			$id_cancion = $rowID['id_cancion'];
		}
		$sqlsentence="INSERT INTO playlist (id_,cancion,id_cancion) VALUES (NULL,'$numero','$id_cancion')";
		$mysqli->query($sqlsentence);
}

	}
	 ?>
</div>

<script src="assets/js/jquery-1.11.2.min.js"></script>
<script src="assets/js/id3-minimized.js"></script>
<script src="assets/js/wavesurfer.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>