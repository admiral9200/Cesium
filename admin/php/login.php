<?php
include("db.php");
session_start();
if (isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    //$pass = password_hash($pass, PASSWORD_DEFAULT);
    $sqlUser = "SELECT * FROM cc_admins WHERE email = ? AND password = ?";
    $stmtUser = $pdo -> prepare($sqlUser);
    $stmtUser -> execute([$email, $pass]);
    if ($stmtUser -> rowCount() == 1){
        $_SESSION['admin'] = $email;
        header('location: ../dashboard.php');
    }
    else{
        $_SESSION['error'] = "Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!";
        header("location: ../index.php");
    }
}
?>