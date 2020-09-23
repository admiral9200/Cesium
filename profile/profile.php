<?php
session_start();
include("../php/db_connect.php");
if (!isset($_SESSION['email'])) header('location: ../');
$email = $_SESSION['email'];

if(isset($_POST['oldpass']) && isset($_POST['newpass'])){
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $resPass = changePass($oldpass, $newpass);
    echo $resPass;
}
else if(isset($_POST['firstName']) && isset($_POST['lastName'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $resCreds = changeCreds($firstName, $lastName);
    echo $resCreds;
}

function changePass($oldpass, $newpass){
    global $email, $pdo;
    $sqlOldPass = "SELECT password FROM cc_users WHERE email = ?";
    $stmtOldPass = $pdo -> prepare($sqlOldPass);
    $stmtOldPass -> execute([$email]);
    $rowOldPassFromFB = $stmtOldPass -> fetch();
    if(password_verify($oldpass, $rowOldPassFromFB['password'])){
        $newpass = password_hash($newpass, PASSWORD_DEFAULT);
        $sqlChangePass = "UPDATE cc_users SET password = ? WHERE email = ?";
        $stmtChangePass = $pdo -> prepare($sqlChangePass);
        $stmtChangePass -> execute([$newpass, $email]);
        if ($stmtChangePass) {
            $_SESSION['msgForPass'] = "<div class='alert alert-success alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                Ο κωδικός σας άλλαξε επιτυχώς
                            </div>";
            return true;   
        }
    }
    else if(!password_verify($oldpass, $rowOldPassFromFB['password'])){
        $_SESSION['msgForPass'] = "<div class='alert alert-danger alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                Ο παλαιός κωδικός δεν είναι σωστός
                            </div>";
        return false;
    }
    else{
        $msg = "Κάτι πήγε λάθος. Προσπάθησε ξανά";
        $_SESSION['msgForPass'] = "<div class='alert alert-danger alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                $msg
                            </div>";
        return false;
    }
}

function changeCreds($firstName, $lastName){
    global $email, $pdo;
    $sqlChangeName = "UPDATE cc_users SET firstName = ?, lastName = ? WHERE email = ?";
    $stmtChangeName = $pdo -> prepare($sqlChangeName);
    $stmtChangeName -> execute([$firstName, $lastName, $email]);
    if ($stmtChangeName) {
        $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            Τα στοιχεία σου άλλαξαν επιτυχώς
                        </div>";
        return true;   
    }
    else{
        return false;
    }
}