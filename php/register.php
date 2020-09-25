<?php
include("db_connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !is_null($_POST['email']) && !is_null($_POST['pass']) && !is_null($_POST['firstName']) && !is_null($_POST['lastName'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $sqlCheckEmail = "SELECT email FROM cc_users WHERE email = ? LIMIT 1";
    $stmtCheckEmail = $pdo -> prepare($sqlCheckEmail);
    $stmtCheckEmail -> execute([$email]);
    $emailToCheck = $stmtCheckEmail -> fetch();
    if ($emailToCheck && ($emailToCheck['email'] === $email)){
        echo "<p class='text-center mt-3' style='color: #dc3545 !important'>Το email αυτό υπάρχει ήδη</p>";
    }
    else if(strlen($pass) > 8){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sqlNewUser = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES(? , ? , ? , ?)";
        $stmtNewUser = $pdo -> prepare($sqlNewUser);
        $stmtNewUser -> execute([$email, $pass, $firstName, $lastName]);
        if($stmtNewUser){
            session_start();
            $_SESSION['msgsuccess'] = true;
            echo true;
        }
        else{
            echo false;
        }
    }
    else{
        echo false;
    }
}