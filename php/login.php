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
        $_SESSION['email'] = $email;
        if(!empty($_POST['rmbrme']) && $_POST['rmbrme'] === true){
            //create cookies
        }
        //log login date and time for user
        echo true;
    }
    else{
        echo "<p class='text-center mt-3' style='color: #dc3545 !important'>Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!</p>";
    }
}
?>