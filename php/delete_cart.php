<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
if(isset($_GET['count'])){
    $countToDelete = $_GET['count'];
    $deleteQuery = "DELETE FROM cc_cart WHERE email = ? AND count = ?";
    $stmtDeleteCoffee = $pdo -> prepare($deleteQuery);
    $stmtDeleteCoffee -> execute([$email, $countToDelete]);
    header("location: ../order.php");
}
else{
    //handle error
}
?>