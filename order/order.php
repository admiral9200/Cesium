<?php
session_start();
if (!isset($_SESSION['email'])) header('location: /');
include("../config/db.connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        echo orderAgain();
        break;
    case 'GET':
        if (isset($_GET['coffees'])){
			$fetchCoffees = $pdo -> query('SELECT * FROM cc_coffees');
			echo json_encode($fetchCoffees -> fetchAll());
		}
        break;
    default:
        echo json_encode($res['status'] = 'fail');
        break;
}

function orderAgain(){
    global $pdo;

    header("Content-Type: application/json");

    $order = file_get_contents('php://input');
    $order = json_decode($order);

    //Get products of order selected
    $sqlOrderAgain = "SELECT * FROM cc_orders_products WHERE id= ?";

    $stmtOrderAgain = $pdo -> prepare($sqlOrderAgain);
    $queryResolved =  $stmtOrderAgain -> execute([$order -> code]);

    if ($queryResolved) {
        return json_encode($stmtOrderAgain -> fetchAll());
    }
    return json_encode($res['status'] = 'fail');
}