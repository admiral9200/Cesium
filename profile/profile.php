<?php
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(400);
    header('location: ../');
}

include("../config/db.connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        header("Content-Type: application/json; charset=UTF-8");
        $req = json_decode(file_get_contents('php://input'));

        if(!empty($req -> oldPassword) && !empty($req -> newPassword)) {

            echo json_encode(changePass($req -> oldPassword, $req -> newPassword));
        }
        else if(!empty($req -> firstName) && !empty($req -> lastName)){

            echo json_encode(changeCreds($req -> firstName, $req -> lastName));
            $_SESSION['firstName'] = $req -> firstName;
        }
        else if ($req -> email === $_SESSION['email']) {
            echo json_encode(deleteUser());
        }
        exit();
    case 'GET':
        if ($_GET['user'] === $_SESSION['email']) {
            echo json_encode(getUser());
        }
        exit();
    default:
        http_response_code(400);
        exit();
}

function changePass($oldpass, $newpass){
    global $pdo;

    $sqlOldPass = "SELECT password FROM cc_users WHERE email = ?";
    $stmtOldPass = $pdo -> prepare($sqlOldPass);
    $stmtOldPass -> execute([$_SESSION['email']]);

    $oldPassword = $stmtOldPass -> fetch();
    if(password_verify($oldpass, $oldPassword['password'])) {

        $newpass = password_hash($newpass, PASSWORD_DEFAULT);

        $sqlChangePass = "UPDATE cc_users SET password = ? WHERE email = ?";
        $stmtChangePass = $pdo -> prepare($sqlChangePass);
        $queryResolved = $stmtChangePass -> execute([$newpass, $_SESSION['email']]);
        
        return $queryResolved ? ['status' => 'success'] : ['error' => 'Internal Error'];

    }
    else if(!password_verify($oldpass, $oldPassword['password'])) {

        return ['error' => 'Ο παλιός κωδικός δεν είναι ίδιος με τον καινούριο'];

    }
    return ['error' => 'Internal Error'];
}

function changeCreds($firstName, $lastName){
    global $pdo;

    $sqlChangeName = "UPDATE cc_users SET firstName = ?, lastName = ? WHERE email = ?";
    $stmtChangeName = $pdo -> prepare($sqlChangeName);
    $queryResolved = $stmtChangeName -> execute([$firstName, $lastName, $_SESSION['email']]);
    
    return $queryResolved ? ['status' => 'success'] : ['error' => 'An Internal Error occured'];
}

function deleteUser(){
    global $pdo;

    $sqlDeleteUser = "DELETE FROM cc_users WHERE email = ?";
    $stmtDeleteUser = $pdo -> prepare($sqlDeleteUser);
    $userResolved = $stmtDeleteUser -> execute([$_SESSION['email']]);

    $sqlDeleteUser1 = "DELETE FROM cc_address WHERE email = ?";
    $stmtDeleteUser1 = $pdo -> prepare($sqlDeleteUser1);
    $addressResolved = $stmtDeleteUser1 -> execute([$_SESSION['email']]);

    $sqlDeleteUser2 = "DELETE FROM cc_orders WHERE email = ?";
    $stmtDeleteUser2 = $pdo -> prepare($sqlDeleteUser2);
    $ordersResolved = $stmtDeleteUser2 -> execute([$_SESSION['email']]);

    if ($userResolved && $addressResolved && $ordersResolved) {
        session_unset();
        session_destroy();
        header('location: ../');
    }
    return ['error' => 'An error occured'];
}

function getUser(){
    global $pdo;

    $sqlLoggedInUser = "SELECT firstName, lastName FROM cc_users WHERE email = ?";
    $resultUser = $pdo -> prepare($sqlLoggedInUser);
    $queryResolver = $resultUser -> execute([$_SESSION['email']]);

    return $queryResolver ? $resultUser -> fetchAll() : ['error' => 'Internal Error'];
}