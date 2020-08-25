<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
$sqlClearCart = "DELETE FROM cart WHERE email = '$email'";
mysqli_query($con, $sqlClearCart);
?>