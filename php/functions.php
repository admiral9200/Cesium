<?php
session_start();
include("../php/db_connect.php");
if (!isset($_SESSION['email'])) header('location: /');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['delete'] == true) {
    echo deleteAccount();
}
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user'])){
    echo getProfile();
}

function getProfile(){
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

function deleteAccount(){
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