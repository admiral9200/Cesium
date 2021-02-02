<?php
include("db.connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @!is_null($_POST['email']) && @!is_null($_POST['pass']) && @!is_null($_POST['firstName']) && @!is_null($_POST['lastName'])){
    echo registerUser();
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST' && @!empty($_POST['email']) && @!empty($_POST['pass'])){
    echo loginUser();
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['delete'] == true) {
    echo deleteUser();
}
else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user'])){
    echo getUser();
}


function loginUser(){
    global $pdo;
    $sqlUser = "SELECT * FROM cc_users WHERE email = ?";
    $stmtUser = $pdo -> prepare($sqlUser);
    $stmtUser -> execute([$_POST['email']]);
    $rowUser = $stmtUser -> fetch();
    if ($stmtUser -> rowCount() == 1 && password_verify($_POST['pass'], $rowUser['password'])){
        session_start();
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['firstName'] = $rowUser['firstName'];
        if(!empty($_POST['rmbrme']) && $_POST['rmbrme'] === true){
            //create cookies
        }
        //log login date and time for user
        return true;
    }
    else{
        return "<p class='text-center mt-3' style='color: #dc3545 !important'>Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!</p>";
    }
}

function registerUser(){
    global $pdo;
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $sqlCheckEmail = "SELECT email FROM cc_users WHERE email = ? LIMIT 1";
    $stmtCheckEmail = $pdo -> prepare($sqlCheckEmail);
    $stmtCheckEmail -> execute([$_POST['email']]);
    $emailToCheck = $stmtCheckEmail -> fetch();
    if ($emailToCheck && ($emailToCheck['email'] === $_POST['email'])){
        return "<p class='text-center mt-3' style='color: #dc3545 !important'>Το email αυτό υπάρχει ήδη</p>";
    }
    else if(strlen($_POST['pass']) > 8){
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $sqlNewUser = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES(? , ? , ? , ?)";
        $stmtNewUser = $pdo -> prepare($sqlNewUser);
        $stmtNewUser -> execute([$_POST['email'], $pass, $firstName, $lastName]);
        if($stmtNewUser){
            session_start();
            $_SESSION['msgsuccess'] = true;
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}

function getUser(){
    session_start();
    global $pdo;
    $sqlLoggedInUser = "SELECT email, firstName, lastName FROM cc_users WHERE email = ?";
    $resultUser = $pdo->prepare($sqlLoggedInUser);
    $resultUser->execute([$_SESSION['email']]);
    if ($resultUser){
        $user = $resultUser->fetchAll();
        $user = json_encode($user);
        return $user;
    }
    else return "Κάτι πήγε λάθος. Δοκίμασε ξανά";
}

function deleteUser(){
    global $pdo;
    $sqlDeleteUser = "DELETE FROM cc_users WHERE email = ?";
    $stmtDeleteUser = $pdo -> prepare($sqlDeleteUser);
    $stmtDeleteUser -> execute([$_SESSION['email']]);
    $sqlDeleteUser1 = "DELETE FROM cc_address WHERE email = ?";
    $stmtDeleteUser1 = $pdo -> prepare($sqlDeleteUser1);
    $stmtDeleteUser1 -> execute([$_SESSION['email']]);
    $sqlDeleteUser2 = "DELETE FROM cc_orders WHERE email = ?";
    $stmtDeleteUser2 = $pdo -> prepare($sqlDeleteUser2);
    $stmtDeleteUser2 -> execute([$_SESSION['email']]);
    $sqlDeleteUser3 = "DELETE FROM cc_cart WHERE email = ?";
    $stmtDeleteUser3 = $pdo -> prepare($sqlDeleteUser3);
    $stmtDeleteUser3 -> execute([$_SESSION['email']]);
    if ($stmtDeleteUser && $stmtDeleteUser1 && $stmtDeleteUser2 && $stmtDeleteUser3) {
        session_unset();
        session_destroy();
        return true;
    }
    else{
        return false;
    }
}