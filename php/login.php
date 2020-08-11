<?php
include("db_connect.php");
session_start();
$errors = array();
if (isset($_POST['login'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']);
    if (count($errors) == 0){
        $pass = md5($pass);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        $firstName = $row[2];
        $lastName = $row[3];
        if (mysqli_num_rows($result) == 1){
            $_SESSION['email'] = $email;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            if (!empty($_POST['rememberme'])){
                setcookie("user_login" , $email, time() + (1 * 365 * 24 * 60 * 60));
                setcookie("pass_login" , $pass, time() + (1 * 365 * 24 * 60 * 60));
                $_SESSION['email'] = $email;
            }
            header('location: ../home.php');
        }
        else{
            $_SESSION['error'] = "Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!";
            header("location: ../index.php");
        }
    }
}
?>