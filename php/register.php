<?php
session_start();
include("db_connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['pass'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $sqlCheckEmail = "SELECT * FROM cc_users WHERE email = ? LIMIT 1";
    $stmtCheckEmail = $pdo -> prepare($sqlCheckEmail);
    $stmtCheckEmail -> execute([$email]);
    $emailToCheck = $stmtCheckEmail -> fetch();
    if ($emailToCheck && ($emailToCheck['email'] === $email)){
        echo "<p class='text-center mt-3' style='color: #dc3545 !important'>Το email αυτό υπάρχει ήδη</p>";
    }
    else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sqlNewUser = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES(? , ? , ? , ?)";
        $stmtNewUser = $pdo -> prepare($sqlNewUser);
        $stmtNewUser -> execute([$email, $pass, $firstName, $lastName]);
        echo "success";
        //header('location: ../success_register.php');
    }
}
?>