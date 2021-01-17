<?php
include("../php/db_connect.php");
session_start();
if (!isset($_SESSION['email'])) header("location: /");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (@!empty($_POST['address']) && @!empty($_POST['state'])) echo insertAddress();
        else if (@!empty($_POST['d'])) { //delete address
            echo deleteAddress();
        }
        else{
            echo    "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                    </div>";
        }
        break;
    case 'GET':
        if (@isset($_GET['q'])) { //check address
            echo checkAddress();
        }
        else if (@isset($_GET['f'])) { //fetch address
            echo fetchAddress();
        }
        else if(@isset($_GET['orders'])){
            echo fetchOrders();
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
    if (gettype(countAddresses()) === 'integer'){
        return countAddresses();
    }
    else {
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                </div>";
    }
}

function deleteAddress(){
    global $pdo;
    $sqlDeleteAddress = "DELETE FROM cc_address WHERE address = ? AND email = ?";
    $stmtDeleteAddress = $pdo -> prepare($sqlDeleteAddress);
    $stmtDeleteAddress -> execute([$_POST['d'], $_SESSION['email']]);
    if ($stmtDeleteAddress) {
        unset($_SESSION['addressExists']);
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
    else if (countAddresses() >= 3){
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Δε μπορείτε να προσθέσετε άλλη διεύθυνση.
                </div>";
    }
    else{
        $sqlInsertAddress = "INSERT INTO cc_address (email, address, state) VALUES (? , ? , ?)";
        $stmtInsertAddress = $pdo -> prepare($sqlInsertAddress);
        $stmtInsertAddress -> execute([$_SESSION['email'], $_POST['address'], $_POST['state']]);
        if ($stmtInsertAddress) {
            return true;
        }
        else return "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>Δεν προσθέθηκε η διεύθυνση. Προσπάθησε ξανά.
                    </div>";
    }
}

function fetchAddress(){
    global $pdo;
    $sqlFetchAddress = "SELECT address, state, active FROM cc_address WHERE email = ?";
    $stmtAddress = $pdo -> prepare($sqlFetchAddress); 
    $stmtAddress -> execute([$_SESSION['email']]);
    if ($stmtAddress) {
        return json_encode($stmtAddress -> fetchAll());
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
        if ($stmtAddress){
            $numAddress = $stmtAddress -> fetch();
            $_SESSION['addressExists'] = (int)$numAddress['count'];
            return (int)$numAddress['count'];
        }
        else {
            $_SESSION['addressExists'] = 0;
            return false;
        }
    }
    catch (PDOException $e){
        return false;
    }
}

function fetchOrders(){
    global $pdo;
    $sqlOrders = "SELECT 
                    cc_orders.*, 
                    GROUP_CONCAT(cc_orders_products.coffee) as coffees,
                    GROUP_CONCAT(cc_orders_products.price) as price,
                    GROUP_CONCAT(cc_orders_products.qty) as qty
                    FROM cc_orders 
                    JOIN cc_orders_products ON cc_orders.id = cc_orders_products.id 
                    WHERE email = ?
                    GROUP BY cc_orders.id
                    ORDER BY cc_orders.id DESC";
    $stmtOrders = $pdo -> prepare($sqlOrders);
    $stmtOrders -> execute([$_SESSION['email']]);
    if($stmtOrders){
        return json_encode($stmtOrders -> fetchAll());
    }
    else{
        return "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
                </div>";
    }
}