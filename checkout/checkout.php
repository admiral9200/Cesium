<?php
session_start();
if (!isset($_SESSION['email'])) header("location: ../");
date_default_timezone_set('Europe/Athens');
include("../php/db_connect.php");
//Paypal Integration not working on localhost
/* if(isset($_POST['payment']) == "paypal"){
    header("location: payment.php");
    die();
} */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])){
        $stmtID = $pdo -> prepare("SELECT id FROM cc_id");
        $stmtID -> execute();
        $rowID = $stmtID -> fetch();
        $id = "cc".$rowID['id'];
        $doorname = $_POST['doorname'];
        $floor = $_POST['floor'];
        $phone = $_POST['phone'];
        $comment = $_POST['comment'];
        $res = checkout($id, $doorname, $floor, $phone, $comment);
        echo $res;
        if($res){
            //Update/Increase ID order number in id table
            $idNumber = $rowID['id'] + 1;
            $sqlIncID = "UPDATE cc_id SET id = ?";
            $stmtIncID = $pdo -> prepare($sqlIncID);
            $stmtIncID -> execute([$idNumber]);
            //Clear Cart after order placed
            $sqlClearCart = "DELETE FROM cc_cart WHERE email = ?";
            $stmtClearCart = $pdo -> prepare($sqlClearCart);
            $stmtClearCart -> execute([$_SESSION['email']]);
        }
}
else if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $res = fetchOrderDetails();
    echo $res;
}
else{
    echo false;
}

function checkout($id, $doorname, $floor, $phone, $comment){
    global $pdo;
    $date = date("d.m.y");
    $time = date("H:i:s");
    $checkoutInfo = "INSERT INTO cc_checkout (id, email, doorname, floor, phone, comment, date, time) VALUES(? , ? , ? , ? , ? , ? , ? , ?)";
    $stmtChekoutInfo = $pdo -> prepare($checkoutInfo);
    $stmtChekoutInfo -> execute([$id, $_SESSION['email'], $doorname, $floor, $phone, $comment, $date, $time]);
    //UPDATE ORDERS OF USERS IN HOME PAGE... send cart values to orderBackendPanel with id from checkout and keep checkout as it is. get order together with same id (checkout, order)
    //cart fetch
    $sqlFetchCart = "SELECT email, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cc_cart WHERE email = ?";
    $stmtFetchCart = $pdo -> prepare($sqlFetchCart);
    $stmtFetchCart -> execute([$_SESSION['email']]);
    while($rowInsertToBackend = $stmtFetchCart -> fetch()){
        $coffee = $rowInsertToBackend['coffee'];
        $sugar = $rowInsertToBackend['sugar'];
        $sugarType = $rowInsertToBackend['sugarType'];
        $milk = $rowInsertToBackend['milk'];
        $cinnamon = $rowInsertToBackend['cinnamon'];
        $choco = $rowInsertToBackend['choco'];
        $price = $rowInsertToBackend['price'];
        $qty = $rowInsertToBackend['qty'];
        //Insert to Backend Panel for process order
        $sqlInsert = "INSERT INTO cc_ordersBackendPanel (id, email, date, time, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty) VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
        $stmtInsertToBackend = $pdo -> prepare($sqlInsert);
        $stmtInsertToBackend -> execute([$id, $_SESSION['email'], $coffee, $sugar, $sugarType, $milk, $cinnamon, $choco, $price, $qty]);
        //Insert to Users home.php
        $sqlInsertToUser = "INSERT INTO cc_orders (id, email, date, time, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty) VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
        $stmtInsertToUser = $pdo -> prepare($sqlInsertToUser);
        $stmtInsertToUser -> execute([$id, $_SESSION['email'], $date, $time, $coffee, $price, $qty]);
    }
    if ($stmtFetchCart && $stmtChekoutInfo && $stmtInsertToBackend && $stmtInsertToUser) {
        $_SESSION['success'] = true;
        return true;
    }
    else{
        return false;
    }
}

function fetchOrderDetails(){
    global $pdo;
    $sqlOrderDetails = "SELECT cc_address.address, cc_checkout.floor, cc_checkout.time FROM cc_address INNER JOIN cc_checkout ON cc_address.email = cc_checkout.email WHERE cc_address.email = ? AND cc_checkout.email = ? AND cc_checkout.id IN (SELECT max(id) FROM cc_checkout WHERE email = ?)";
    $stmtOrderDetails = $pdo -> prepare($sqlOrderDetails);
    $stmtOrderDetails -> execute([$_SESSION['email'], $_SESSION['email'], $_SESSION['email']]);
    if ($stmtOrderDetails) {
        $orderDetails = $stmtOrderDetails -> fetchAll();
        $orderDetails = json_encode($orderDetails);
        return $orderDetails;
    }
    else{
        return false;
    }
}