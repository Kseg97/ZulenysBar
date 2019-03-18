<?php
include(__DIR__ . '/../connection.php');
try{
    $db_con = new PDO("mysql:host={$host};dbname={$db}", $user, $pw);
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}

if(isset($_POST['Submit'])) {
    $song = $_FILES["song"]["name"];
    $genero = $_POST["song_gen"];
    
    $genero = $row_genre_id[1];
}

try {
    move_uploaded_file($_FILES["song"]["tmp_name"],"../player/" . $_FILES["song"]["name"]);
    $stmt = $db_con->prepare("INSERT INTO lista_canciones (cancion,genre) VALUES( :song_name, :genre)");
    $stmt->bindParam(":song_name", $song);
    $stmt->bindParam(":genre", $genero);

    if($stmt->execute()) {
        header("Location: ../admin.php?tab=3&subtab=1&msg=10");
    } else {
        header("Location: ../admin.php?tab=3&subtab=2&msg=11");
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>
