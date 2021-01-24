<?php
session_start();
if (!isset($_SESSION['email'])) header('location: /');
$email = $_SESSION['email'];
include("../php/db_connect.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if(!empty($_POST['orderagain'])){
            echo orderAgain();
		}
		else if (!empty($_POST['coffees'])){
			$fetchCoffees = $pdo -> query('SELECT * FROM cc_coffees');
			echo json_encode($fetchCoffees -> fetchAll());
		}
        break;
    case 'GET':
        break;
    default:
        echo false;
        break;
}

function orderAgain(){
    global $pdo;
    //Get products of order selected
    $sqlOrderAgain = "SELECT 
                    cc_orders.*, 
                    GROUP_CONCAT(cc_orders_products.coffee) as coffees,
                    GROUP_CONCAT(cc_orders_products.price) as price,
                    GROUP_CONCAT(cc_orders_products.qty) as qty
                    FROM cc_orders 
                    JOIN cc_orders_products ON cc_orders.id = cc_orders_products.id 
                    WHERE email = ?
                    GROUP BY cc_orders.id
                    ORDER BY cc_orders.id DESC";
    $stmtOrderAgain = $pdo -> prepare($sqlOrderAgain);
    $stmtOrderAgain -> execute([$_POST['orderagain']]);
    if ($stmtOrderAgain) { //clear the cart and check the query ran
        while ($order = $stmtOrderAgain -> fetch()) {
            //Keep a counter in cart
            $cart_query = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco FROM cc_cart WHERE email = ?";
            $stmtCart = $pdo -> prepare($cart_query);
            $stmtCart -> execute([$_SESSION['email']]);
            $count = $stmtCart -> rowCount();
            //Insert coffee to cart
            $count++;
            $cart_query = "INSERT INTO cc_cart (email, count, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty) VALUES( ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
            $stmtCartInsert = $pdo -> prepare($cart_query);
            $stmtCartInsert -> execute([$_SESSION['email'], $count, $order['coffee'], $order['sugar'], $order['sugarType'], $order['milk'], $order['cinnamon'], $order['choco'], $order['price'], $order['qty']]);
        }
        if ($stmtCartInsert) {
            $_SESSION['isCartEmpty'] = true;
            return true;
        }
    }
    return false;
}