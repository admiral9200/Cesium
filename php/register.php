<?php
session_start();
include("db_connect.php");
if (isset($_POST['signup'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $sqlCheckEmail = "SELECT * FROM cc_users WHERE email = ? LIMIT 1";
    $stmtCheckEmail = $pdo -> prepare($sqlCheckEmail);
    $stmtCheckEmail -> execute([$email]);
    $emailToCheck = $stmtCheckEmail -> fetch();
    if ($emailToCheck && ($emailToCheck['email'] === $email)){
        $_SESSION['msg'] = "Το email αυτό υπάρχει ήδη";
        header('location: ../index.php');
    }
    else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sqlNewUser = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES(? , ? , ? , ?)";
        $stmtNewUser = $pdo -> prepare($sqlNewUser);
        $stmtNewUser -> execute([$email, $pass, $firstName, $lastName]);
        header('location: ../success_register.php');
    }
}
?>