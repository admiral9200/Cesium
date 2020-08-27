<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
$sqlClearCart = "DELETE FROM cc_cart WHERE email = '$email'";
mysqli_query($con, $sqlClearCart);
?>