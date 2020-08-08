<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
if (isset($_POST['add'])){
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $add_address_query = "INSERT INTO address (email, address, state) VALUES ('$email', '$address', '$state')";
    mysqli_query($con, $add_address_query);
    header("location: ../home.php");
}
?>