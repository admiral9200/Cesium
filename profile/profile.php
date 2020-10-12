<?php
session_start();
include("../php/db_connect.php");
if (!isset($_SESSION['email'])) header('location: ../');

if(!empty($_POST['oldpass']) && !empty($_POST['newpass'])){
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $resPass = changePass($oldpass, $newpass);
    echo $resPass;
}
else if(!empty($_POST['firstName']) && !empty($_POST['lastName'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $resCreds = changeCreds($firstName, $lastName);
    echo $resCreds;
}
else if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $res = getProfile();
    echo $res;
}

function changePass($oldpass, $newpass){
    global $pdo;
    $sqlOldPass = "SELECT password FROM cc_users WHERE email = ?";
    $stmtOldPass = $pdo -> prepare($sqlOldPass);
    $stmtOldPass -> execute([$_SESSION['email']]);
    $rowOldPassFromFB = $stmtOldPass -> fetch();
    if(password_verify($oldpass, $rowOldPassFromFB['password'])){
        $newpass = password_hash($newpass, PASSWORD_DEFAULT);
        $sqlChangePass = "UPDATE cc_users SET password = ? WHERE email = ?";
        $stmtChangePass = $pdo -> prepare($sqlChangePass);
        $stmtChangePass -> execute([$newpass, $_SESSION['email']]);
        if ($stmtChangePass) return true;   
        else return "Κάτι πήγε λάθος. Προσπάθησε ξανά";
    }
    else if(!password_verify($oldpass, $rowOldPassFromFB['password'])) return "Ο παλιός κωδικός δεν είναι σωστός";
    else return "Κάτι πήγε λάθος. Προσπάθησε ξανά";
}

function changeCreds($firstName, $lastName){
    global $pdo;
    $sqlChangeName = "UPDATE cc_users SET firstName = ?, lastName = ? WHERE email = ?";
    $stmtChangeName = $pdo -> prepare($sqlChangeName);
    $stmtChangeName -> execute([$firstName, $lastName, $_SESSION['email']]);
    return $stmtChangeName ? true : "Κάτι πήγε λάθος. Δοκίμασε ξανά";
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