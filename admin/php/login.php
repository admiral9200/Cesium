<?php
require("db.php");
session_start();
if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['pass'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $sqlUser = "SELECT * FROM cc_staff WHERE email = ? AND password = ?";
    $stmtUser = $pdo -> prepare($sqlUser);
    $stmtUser -> execute([$email, $pass]);
    if($stmtUser) {
        if($stmtUser -> rowCount() == 1){
            $_SESSION['admin'] = $email;
            echo true;
        }
        else{
            echo "Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!";
        }
    }
    else{
        echo false;
    }
}
?>