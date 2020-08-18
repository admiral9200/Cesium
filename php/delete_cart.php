<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
if(isset($_GET['count'])){
    $countToDelete = mysqli_real_escape_string($con, $_GET['count']);
    $deleteQuery = "DELETE FROM cart WHERE email = '$email' AND count = '$countToDelete'";
    mysqli_query($con, $deleteQuery);
    header("location: ../order.php");
}
else{
    //handle error
}
?>