<?php
include("../php/db_connect.php");
session_start();
if (!isset($_SESSION['email'])) header("location: ../");

if (@!empty($_POST['address']) && @!empty($_POST['state'])){
    $res = insertAddress();
    echo $res;
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && @!empty($_GET['address'])){
    $res = deleteAddress();
    echo $res;
}
else if($_SERVER['REQUEST_METHOD'] === 'GET' && @isset($_GET['check'])){
    $res = checkAddress();
    echo $res;
}
else if($_SERVER['REQUEST_METHOD'] === 'GET' && @isset($_GET['fetch'])){
    $res = fetchAddress();
    echo $res;
}
else{
    echo    "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
            </div>";
}

function checkAddress(){
    global $pdo;
    $sqlFetchAddress = "SELECT * FROM cc_address WHERE email = ?";
    $stmtAddress = $pdo -> prepare($sqlFetchAddress);
    $stmtAddress -> execute([$_SESSION['email']]);
    if ($stmtAddress) {
        $numAddress = $stmtAddress -> rowCount();
        return $numAddress;
    }
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
    if (preg_match('/[^a-zA-Z0-9\-\s]+/i', $_POST['address']) || preg_match('/[^a-zA-Z0-9\-\s]+/i', $_POST['state'])) {
        return false;
    }
    else{
        $check_address_sum = "SELECT address FROM cc_address WHERE email = ?";
        $stmtCheckAddressesSum = $pdo -> prepare($check_address_sum);
        $stmtCheckAddressesSum -> execute([$_SESSION['email']]);
        if ($stmtCheckAddressesSum -> rowCount() >= 1){
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
            else return false;
        }
    }
}

function fetchAddress(){
    global $pdo;
    $sqlFetchAddress = "SELECT address, state FROM cc_address WHERE email = ?";
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