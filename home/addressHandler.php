<?php
include("../config/db.connect.php");
session_start();
if (!isset($_SESSION['email'])) header("location: /");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':

        header("Content-Type: application/json");

        $address = file_get_contents('php://input');
        $address = json_decode($address);

        if (@!empty($address -> address) && @!empty($address -> state)) {
            echo insertAddress($address -> address, $address -> state);
        }
        else if (@!empty($address -> address)) { //delete address
            echo deleteAddress($address -> address);
        }
        else {
            echo json_encode($res['status'] = 'fail');
        }
        break;
    case 'GET':
        if (@isset($_GET['q'])) { //check address
            echo json_encode($res['count'] = countAddresses());
        }
        else if (@isset($_GET['f'])) { //fetch address
            echo fetchAddress();
        }
        else if(@isset($_GET['orders'])){
            echo fetchOrders();
        }
        break;
}

function deleteAddress($address) {
    global $pdo;

    $sqlDeleteAddress = "DELETE FROM cc_address WHERE address = ? AND email = ?";
    $stmtDeleteAddress = $pdo -> prepare($sqlDeleteAddress);
    $stmtDeleteAddress -> execute([$address, $_SESSION['email']]);

    if ($stmtDeleteAddress) {
        unset($_SESSION['addressExists']);
        return json_encode($res['status'] = 'success');
    }
    return json_encode($res['status'] = 'fail');
}

function insertAddress ($address, $state) {
    global $pdo;

    $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

    if (preg_match($pattern, $address) && preg_match($pattern, $state)) {
        return json_encode($res['status'] = 'Not Valid');   
    }
    else if (countAddresses() >= 3){
        return json_encode($res['status'] = 'Over Limit');
    }
    else{

        $sqlInsertAddress = "INSERT INTO cc_address (email, address, state, active) VALUES (? , ? , ? , 1)";
        $stmtInsertAddress = $pdo -> prepare($sqlInsertAddress);
        $addressInsertedToDB = $stmtInsertAddress -> execute([$_SESSION['email'], $address, $state]);

        if ($addressInsertedToDB) {
            return json_encode($res['status'] = 'success');
        }
    }
    return json_encode($res['status'] = 'fail');
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
        return json_encode($res['status'] = 'fail');
    }
}

function countAddresses(){
    global $pdo;
    try {
        $sqlFetchAddress = "SELECT COUNT(*) as count FROM cc_address WHERE email = ?";
        $stmtAddress = $pdo -> prepare($sqlFetchAddress);
        $queryResolved = $stmtAddress -> execute([$_SESSION['email']]);

        if ($queryResolved){
            $numAddress = $stmtAddress -> fetch();
            $_SESSION['addressExists'] = (int)$numAddress['count'];
            return (int)$numAddress['count'];
        }
        $_SESSION['addressExists'] = 0;
        return 0;
    }
    catch (PDOException $error){
        return $error;
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
    return json_encode($res['status'] = 'fail');
}