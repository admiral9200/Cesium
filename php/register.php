<?php
session_start();
include("db_connect.php");
$email = '';
$pass = '';
$firstName = '';
$lastName = '';
$errors = array();
if (isset($_POST['signup'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']);
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email_check_query = "SELECT * FROM cc_users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $email_check_query);
    $email_exists = mysqli_fetch_assoc($result);
    if ($email_exists){
        if ($email_exists['email'] === $email) {
            array_push($errors, "Το email αυτό υπάρχει ήδη!");
            header('location: ../index.php');
        }
    }
    if (count($errors) == 0){
        $pass = md5($pass);
        $query = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES('$email', '$pass', '$firstName', '$lastName')";
        mysqli_query($con, $query);
        header('location: ../success_register.php');
    }
}
?>