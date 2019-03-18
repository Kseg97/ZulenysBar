<?php
include(__DIR__ . '/../connection.php');    
try{
    
    $db_con = new PDO("mysql:host={$host};dbname={$db}", $user, $pw);
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo $e->getMessage();
}
$get_id=$_GET['id'];
$stmt = $db_con->prepare("SELECT * FROM  lista_bebidas WHERE id = '$get_id'");
        $stmt->execute();
while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    ?>
    <?php  unlink("uploads/".$row['drink_img']); ?>
    <?php
}
    ?>
<?php
$get_id=$_GET['id'];
// sql to delete a record
$sql = "Delete from lista_bebidas where id = '$get_id'";
// use exec() because no results are returned
$db_con->exec($sql);
header("Location: ../admin.php?tab=2&msg=8");
?>