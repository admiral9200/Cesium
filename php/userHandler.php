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
            else {
                return ['status' => 'Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!'];
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
        $sanitizedEmail = filter_var($req -> email, FILTER_SANITIZE_EMAIL);

        if ($sanitizedEmail !== $req -> email){
            return ['error' => 'Email is not valid'];
        }
        
        $sqlCheckEmail = "SELECT email FROM cc_users WHERE email = ? LIMIT 1";
        $stmtCheckEmail = $pdo -> prepare($sqlCheckEmail);
        $stmtCheckEmail -> execute([$req -> email]);

        $emailToCheck = $stmtCheckEmail -> fetch();

        if ($emailToCheck && ($emailToCheck['email'] === $req -> email)){
            return ['status' => 'Το email αυτό υπάρχει ήδη!'];
        }

        if (filter_var($req -> email , FILTER_VALIDATE_EMAIL) && strlen($req -> password) > 8){
            
            $password = password_hash($req -> password, PASSWORD_DEFAULT);

            $sqlNewUser = "INSERT INTO cc_users (email, password, firstName, lastName) VALUES(? , ? , ? , ?)";
            $stmtNewUser = $pdo -> prepare($sqlNewUser);
            $queryResolved = $stmtNewUser -> execute([$req -> email, $password, $req -> firstName, $req -> lastName]);

            if ($queryResolved){
                return ['status' => 'success'];
            }
            else{
                return ['error' => 'An Internal Server Error occured'];
            }
        }
        else{
            return ['error' => 'An Internal Server Error occured'];
        } 
    }
    catch (Error $error) {
        return ['error' => $error];
    }
}