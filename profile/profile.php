<?php
session_start();
include("../php/db_connect.php");
if (!isset($_SESSION['email'])) header('location: ../');

if(!empty($_POST['oldpass']) && !empty($_POST['newpass'])){
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    echo changePass($oldpass, $newpass);
}
else if(!empty($_POST['firstName']) && !empty($_POST['lastName'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    echo changeCreds($firstName, $lastName);
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