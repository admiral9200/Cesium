<?php
session_start();
include("db_connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['pass'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $sqlUser = "SELECT * FROM cc_users WHERE email = ?";
    $stmtUser = $pdo -> prepare($sqlUser);
    $stmtUser -> execute([$email]);
    $rowUser = $stmtUser -> fetch();
    if ($stmtUser -> rowCount() == 1 && password_verify($pass, $rowUser['password'])){
        if (isset($_POST['rememberme'])){
            setcookie("user" , $email, time() + (1 * 365 * 24 * 60 * 60));
            setcookie("pass" , $pass, time() + (1 * 365 * 24 * 60 * 60));
        }
        session_destroy();
        session_start();
        $_SESSION['email'] = $email;
        echo true;
    }
    else{
        echo "<p class='text-center mt-3' style='color: #dc3545 !important'>Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!</p>";
    }
}
?>