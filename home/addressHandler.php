<?php
session_start();
if (!isset($_SESSION['email'])) {
    http_response_code(400);
    header("location: /");
}
include("../config/db.connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        header("Content-Type: application/json; charset=UTF-8");
        $req = json_decode(file_get_contents('php://input'));

        if (@!empty($req -> address) && @!empty($req -> state)) {
            echo json_encode(insertAddress($req -> address, $req -> state));
            exit();
        }
        else if (@!empty($req -> address)) { //delete address
            echo json_encode(deleteAddress($req -> address));
            exit();
        }
        else {
            echo json_encode($res['status'] = 'fail');
            exit();
        }
        break;
    case 'GET':
        if (@isset($_GET['q'])) { //check address
            echo json_encode($res['count'] = countAddresses());
            exit();
        }
        else if (@isset($_GET['f'])) { //fetch address
            echo json_encode(fetchAddress());
            exit();
        }
        else if(@isset($_GET['orders'])){
            echo json_encode(fetchOrders());
            exit();
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
        return ['status' => 'success'];
    }
    $res = ['error' => 'Internal Error'];
    return $res;
}

function insertAddress ($address, $state) {
    global $pdo;

    $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

    if (preg_match($pattern, $address) && preg_match($pattern, $state)) {
        $res = ['error' => 'Not Valid'];
    }
    else if (countAddresses() >= 3){
        $res = ['error' => 'Over Limit'];
    }
    else {
        $sqlInsertAddress = "INSERT INTO cc_address (email, address, state, active) VALUES (? , ? , ? , 1)";
        $stmtInsertAddress = $pdo -> prepare($sqlInsertAddress);
        $addressInsertedToDB = $stmtInsertAddress -> execute([$_SESSION['email'], $address, $state]);

        $addressInsertedToDB ? $res = ['status' => 'success'] : $res = ['error' => 'Internal Error'];
    }
    return $res;
}

function fetchAddress(){
    global $pdo;

    $sqlFetchAddress = "SELECT address, state, active FROM cc_address WHERE email = ?";
    $stmtAddress = $pdo -> prepare($sqlFetchAddress); 
    $queryResolved = $stmtAddress -> execute([$_SESSION['email']]);

    return $queryResolved ? $stmtAddress -> fetchAll() : ['error' => 'Internal Error'];
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
    $ifOrdersFetched = $stmtOrders -> execute([$_SESSION['email']]);

    return $ifOrdersFetched ? $stmtOrders -> fetchAll() : ['error' => 'Internal Error'];
}

http_response_code(400);
exit();