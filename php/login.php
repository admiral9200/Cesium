<?php
include("db_connect.php");
session_start();
if (isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass = md5($pass);
    $sqlUser = "SELECT * FROM cc_users WHERE email = ? AND password = ?";
    $stmtUser = $pdo -> prepare($sqlUser);
    $stmtUser -> execute([$email, $pass]);
    if ($stmtUser -> rowCount() == 1){
        if (!empty($_POST['rememberme'])){
            setcookie("user_login" , $email, time() + (1 * 365 * 24 * 60 * 60));
            setcookie("pass_login" , $pass, time() + (1 * 365 * 24 * 60 * 60));
        }
        $_SESSION['email'] = $email;
        header('location: ../home.php');
    }
    else{
        $_SESSION['error'] = "Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!";
        header("location: ../index.php");
    }
}
?>