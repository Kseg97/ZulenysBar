
  <div id="responsive" class="section scrollspy">
    <div class="row">
      <div class="col s12 m10 offset-m1 l8 offset-l2">
        <table class="table">
          <thead>
            <tr>
              <th>Orden</th>
              <th>Nombre</th>
              <th>Género</th>
            </tr>
          </thead>
          <?php
          include(__DIR__ . '/../connection.php');
          $mysqli = new mysqli($host, $user, $pw, $db);
          $getsongsplaylist = "SELECT * FROM playlist LIMIT 5"; //trae la cancion de playlist...
          $songsPlaylist   = $mysqli ->query($getsongsplaylist);
          $counter = 0;
          while ($row = $songsPlaylist -> fetch_assoc()) {
            $song = $row['cancion'];
            $getGenre = "SELECT genre FROM lista_canciones where cancion = '$song'";
            $genreSql = $mysqli -> query($getGenre);
            while ($genreRow = $genreSql -> fetch_assoc()) {
              $genre = $genreRow['genre'];
              # code...
            }
            $counter = $counter + 1;

            # code...
            ?>
            <tr>
              <td><?php echo $counter; ?></td>
              <td><?php echo $song; ?></td>
              <td>
                <?php 
                  $sql_genre_id = "SELECT * from genero_canciones where id='$genre'";
                  $result_genre_id = $mysqli->query($sql_genre_id);
                  $row_genre_id = $result_genre_id->fetch_array();
                  echo $row_genre_id[1]; 
                ?>
              </td>
              </tr>
            <?php
          }
          ?>
          </table>
        </div>
      </div>
    </div>
