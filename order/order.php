<?php
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(400);
    header("location: /");
}

include("../config/db.connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        
        header("Content-Type: application/json");
        $req = json_decode(file_get_contents('php://input'));

        echo json_encode(orderAgain());
        exit();

    case 'GET':
        if (isset($_GET['coffees'])) {
			echo json_encode(fetchCoffees());
		}
        exit();
}

function fetchCoffees() {
    global $pdo;

    $queryResolved = $stmtCoffees = $pdo -> query('SELECT * FROM cc_coffees');

    return $queryResolved ? $stmtCoffees -> fetchAll() : ['error' => 'Database Error'];
}

function orderAgain(){
    global $pdo;

    //Get products of order selected
    $sqlOrderAgain = "SELECT * FROM cc_orders_products WHERE id= ?";
    $stmtOrderAgain = $pdo -> prepare($sqlOrderAgain);
    $queryResolved =  $stmtOrderAgain -> execute([$req -> code]);

    return $queryResolved ? $stmtOrderAgain -> fetchAll() : ['error' => 'Database Error'];
}

http_response_code(400);
exit();