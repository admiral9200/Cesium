<?php
include("../php/db_connect.php");
session_start();
if (!isset($_SESSION['email'])) header("location: ../");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (@!empty($_POST['address']) && @!empty($_POST['state'])) echo insertAddress();
        else{
            echo    "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                    </div>";
        }
        break;
    case 'GET':
        if (@!empty($_GET['d'])) { //delete address
            echo deleteAddress();
        }
        else if (@isset($_GET['q'])) { //check address
            echo checkAddress();
        }
        else if (@isset($_GET['f'])) { //fetch address
            echo fetchAddress();
        }
        else{
            echo    "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                    </div>";
        }
        break;
    default:
        echo    "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                </div>";
        break;
}

function checkAddress(){
    if (countAddresses()) return countAddresses();
    else{
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                </div>";
    }
}

function deleteAddress(){
    global $pdo;
    $sqlDeleteAddress = "DELETE FROM cc_address WHERE address = ? AND email = ?";
    $stmtDeleteAddress = $pdo -> prepare($sqlDeleteAddress);
    $stmtDeleteAddress -> execute([$_GET['address'], $_SESSION['email']]);
    if ($stmtDeleteAddress) {
        unset($_SESSION['address']);
        return "<div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Η διεύθυνση διαγράφηκε.
                </div>";
    }
    else{
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                </div>";
    }
}

function insertAddress(){
    global $pdo;
    $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
    if (preg_match($pattern, $_POST['address']) && preg_match($pattern, $_POST['state'])) {
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Δεν είναι έγκυρο αυτό που συμπλήρωσες.
                </div>";   
    }
    else{
        if (countAddresses() >= 3){
            return "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>Δε μπορείτε να προσθέσετε άλλη διεύθυνση.
                    </div>";
        }
        else{
            $sqlInsertAddress = "INSERT INTO cc_address (email, address, state) VALUES (? , ? , ?)";
            $stmtInsertAddress = $pdo -> prepare($sqlInsertAddress);
            $stmtInsertAddress -> execute([$_SESSION['email'], $_POST['address'], $_POST['state']]);
            if ($stmtInsertAddress) {
                $_SESSION['address'] = true;
                return true;
            }
            else return "<div class='alert alert-danger alert-dismissible fade show'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>Δεν προσθέθηκε η διεύθυνση. Προσπάθησε ξανά.
                        </div>";
        }
    }
}

function fetchAddress(){
    global $pdo;
    $sqlFetchAddress = "SELECT address, state FROM cc_address";
    $stmtAddress = $pdo -> prepare($sqlFetchAddress); 
    $stmtAddress -> execute([$_SESSION['email']]);
    if ($stmtAddress) {
        $addresses = $stmtAddress -> fetchAll();
        $addresses = json_encode($addresses);
        return $addresses;
    }
    else{
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                </div>";
    }
}

function countAddresses(){
    global $pdo;
    try{
        $sqlFetchAddress = "SELECT COUNT(*) as count FROM cc_address WHERE email = ?";
        $stmtAddress = $pdo -> prepare($sqlFetchAddress);
        $stmtAddress -> execute([$_SESSION['email']]);
        $numAddress = $stmtAddress -> fetch();
        return $numAddress['count'];
    }
    catch (PDOException $e){
        return false;
    }
}