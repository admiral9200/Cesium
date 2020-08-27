<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
if (isset($_POST['add'])){
    $check_address_sum = "SELECT * FROM cc_address WHERE email='$email'";
    $check_query = mysqli_query($con, $check_address_sum);
    if (mysqli_num_rows($check_query) >= 3){
        $_SESSION['addresses'] = "Δεν μπορείτε να προσθέσετε άλλη διέυθυνση.";
        header("location: ../home.php");
    }
    else{
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $state = mysqli_real_escape_string($con, $_POST['state']);
        $add_address_query = "INSERT INTO cc_address (email, address, state) VALUES ('$email', '$address', '$state')";
        mysqli_query($con, $add_address_query);
        header("location: ../home.php");
    }
}
?>