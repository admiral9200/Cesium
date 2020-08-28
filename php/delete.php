<?php
include("db_connect.php");
session_start();
if (isset($_GET['address'])){
    $address_to_delete = $_GET['address'];
    $sqlDeleteAddress = "DELETE FROM cc_address WHERE address = ?";
    $stmtDeleteAddress = $pdo -> prepare($sqlDeleteAddress);
    $stmtDeleteAddress -> execute([$address_to_delete]);
    $_SESSION['delete_message'] = "Η διεύθυνση διαγράφηκε.";
    header("location: ../home.php");
}
else{
    //handle error
}
?>