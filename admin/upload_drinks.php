<?php
include(__DIR__ . '/../connection.php'); 
try{    
    $db_con = new PDO("mysql:host={$host};dbname={$db}", $user, $pw);
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}

if(isset($_POST['Submit'])) {        
    $drink_img=$_FILES["image"]["name"];
    $nombre=$_POST['drink_name'];
    $precio=$_POST['price'];
}

try {
    move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/" . $_FILES["image"]["name"]);
    $stmt = $db_con->prepare("INSERT INTO lista_bebidas (precio,drink_img,nombre) VALUES( :precio, :drink_img, :nombre)");
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":precio", $precio);
    $stmt->bindParam(":drink_img", $drink_img);    
    
    if($stmt->execute()) {
        header("Location: ../admin.php?tab=2&subtab=3&msg=6");
    } else {
        header("Location: ../admin.php?tab=2&subtab=2&msg=7");
    }    
} catch(PDOException $e) {
    echo $e->getMessage();
}    
?>