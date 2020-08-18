<?php
include("db_connect.php");
session_start();
if (isset($_GET['address'])){
    $address_to_delete = mysqli_real_escape_string($con, $_GET['address']);
    $delete_query = "DELETE FROM address WHERE address = '$address_to_delete'";
    mysqli_query($con, $delete_query);
    $_SESSION['delete_message'] = "Η διεύθυνση διαγράφηκε.";
    header("location: ../home.php");
}
else{
    //handle error
}
?>