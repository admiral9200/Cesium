<?php
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(400);
    header("location: /");
}

date_default_timezone_set('Europe/Athens');
include_once("../config/db.connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':

        header("Content-Type: application/json; charset=UTF-8");
        $req = json_decode(file_get_contents('php://input'));

        if (!empty($req -> payment) && !empty($req -> doorname) && !empty($req -> floor)) {
            echo json_encode(completeOrder($req));
        }
        exit();
    case 'GET':
        $sqlOrderDetails = "SELECT cc_address.address, cc_orders.floor, cc_orders.time 
                            FROM cc_address 
                            JOIN cc_orders ON cc_address.email = cc_orders.email 
                            WHERE cc_address.email = ? AND cc_orders.email = ? AND cc_orders.id 
                            IN (SELECT max(id) FROM cc_orders WHERE email = ?)";

        $stmtOrderDetails = $pdo -> prepare($sqlOrderDetails);
        $queryResolved = $stmtOrderDetails -> execute([$_SESSION['email'], $_SESSION['email'], $_SESSION['email']]);
        
        if ($queryResolved) {
            echo json_encode(['status' => 'success']);
            exit();
        }
        echo json_encode(['error' => 'Internal Error']);
        exit();
}

function completeOrder($cartData) {
    global $pdo;

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

            $sqlInsertProductsDetails = "INSERT INTO cc_orders_products (id, coffee, sugar, sugarType, milk, choco, cinnamon, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsertProductsDetails = $pdo -> prepare($sqlInsertProductsDetails);
            $coffeesInserted = $stmtInsertProductsDetails -> execute([
                                            $id['id'],
                                            $coffee -> coffee,
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

    if($orderPlaced && $orderIdMatches && $coffeesInserted) {
        return ['status' => 'success'];
    }
    return ['error' => 'Internal Error'];
}

http_response_code(400);
exit();