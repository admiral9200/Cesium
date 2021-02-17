<?php
include("../config/db.connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        header("Content-Type: application/json; charset=UTF-8");
        $req = json_decode(file_get_contents('php://input'));
        
        if (@!empty($req -> email) && @!empty($req -> pass)) {
            echo json_encode(loginUser($req -> email, $req -> pass, $req -> rememberme));
            exit();
        }
        else if (@!empty($req -> email) && @!empty($req -> pass) && @!empty($req -> firstName) && @!empty($req -> lastName)) {
            echo json_encode(signUp($req));
            exit();
        }
        else {
            echo json_encode($res['status'] = 'fail');
            exit();
        }
}


function loginUser($email, $pass, $rememberme){
    global $pdo;

    try {
        $sqlUser = "SELECT * FROM cc_users WHERE email = ?";
        $stmtUser = $pdo -> prepare($sqlUser);
        $queryResolved = $stmtUser -> execute([$email]);

        if ($queryResolved) {
            $user = $stmtUser -> fetch();

            if ($stmtUser -> rowCount() === 1){

                if (password_verify($pass, $user['password'])) {
                    session_start();

                    $_SESSION['email'] = $email;
                    $_SESSION['firstName'] = $user['firstName'];

                    if(!empty($rememberme)){
                        //TODO: Create cookies for users
                    }
                    //TODO: log login data for user

                    return ['status' => 'success'];
                }
                else {
                    return ['status' => 'Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!'];
                }
            }
        }    
    }
    catch (Error $error) {
        return ['error' => $error];
    }
}

function signUp($req){
    global $pdo;
    
    try {
        $sqlCheckEmail = "SELECT email FROM cc_users WHERE email = ? LIMIT 1";
        $stmtCheckEmail = $pdo -> prepare($sqlCheckEmail);
        $stmtCheckEmail -> execute([$_POST['email']]);

        $emailToCheck = $stmtCheckEmail -> fetch();
        if ($emailToCheck && ($emailToCheck['email'] === $req -> email)){
            return ['status' => 'Το email αυτό υπάρχει ήδη'];
        }
        else if(strlen($_POST['pass']) > 8){
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $sqlNewUser = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES(? , ? , ? , ?)";
            $stmtNewUser = $pdo -> prepare($sqlNewUser);
            $stmtNewUser -> execute([$_POST['email'], $pass, $req -> firstName, $req -> lastName]);
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
    catch (Error $error) {
    }
}