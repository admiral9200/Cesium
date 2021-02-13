<?php
session_start();
if (!isset($_SESSION['email'])) header("location: /");
date_default_timezone_set('Europe/Athens');
@include_once("../config/db.connect.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    header("Content-Type: application/json");

    $cartData = file_get_contents('php://input');
    $cartData = json_decode($cartData);

    $date = date("d.m.y");
    $time = date("H:i:s");

    $sqlInsertToUser = "INSERT INTO cc_orders (email, date, time, payment, doorname, floor, phone, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsertToUser = $pdo -> prepare($sqlInsertToUser);
    $orderPlaced = $stmtInsertToUser -> execute([
                                    $_SESSION['email'], 
                                    $date, 
                                    $time, 
                                    $cartData -> payment, 
                                    $cartData -> doorname, 
                                    $cartData -> floor, 
                                    $cartData -> phone, 
                                    $cartData -> comment
                                ]);

    $sqlGetID = "SELECT id FROM cc_orders WHERE email = ? AND date = ? AND time = ?";
    $stmtGetID = $pdo -> prepare($sqlGetID);
    $orderIdMatches = $stmtGetID -> execute([$_SESSION['email'], $date, $time]);
    $id = $stmtGetID -> fetch();

    foreach ($cartData as $key => $value) {
        if (strpos($key, '_') !== false) {
            $coffee = json_decode($cartData -> $key);

            $sqlInsertProductsDetails = "INSERT INTO cc_orders_products (id, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsertProductsDetails = $pdo -> prepare($sqlInsertProductsDetails);
            $coffeesInserted = $stmtInsertProductsDetails -> execute([
                                            $id['id'],
                                            $coffee -> name,
                                            $coffee -> sugar,
                                            $coffee -> sugarType,
                                            $coffee -> milk,
                                            $coffee -> cinnamon,
                                            $coffee -> choco,
                                            $coffee -> price,
                                            $coffee -> qty,
                                        ]);  
        }
    }

    if($orderPlaced && $orderIdMatches && $coffeesInserted) echo true;
    else echo false;
}
else if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sqlOrderDetails = "SELECT cc_address.address, cc_orders.floor, cc_orders.time FROM cc_address JOIN cc_orders ON cc_address.email = cc_orders.email WHERE cc_address.email = ? AND cc_orders.email = ? AND cc_orders.id IN (SELECT max(id) FROM cc_orders WHERE email = ?)";
    $stmtOrderDetails = $pdo -> prepare($sqlOrderDetails);
    $stmtOrderDetails -> execute([$_SESSION['email'], $_SESSION['email'], $_SESSION['email']]);
    if ($stmtOrderDetails) {
        $orderDetails = $stmtOrderDetails -> fetchAll();
        $orderDetails = json_encode($orderDetails);
        echo $orderDetails;
    }
    else{
        echo false;
    }
}
else{
    echo false;
}