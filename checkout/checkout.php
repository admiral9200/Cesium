<?php
session_start();
date_default_timezone_set('Europe/Athens');
include("../php/db_connect.php");
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) header("location: ../home/");
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
            $stmtClearCart -> execute([$email]);
        }
}
else{
    //handle error POST
}

function checkout($id, $doorname, $floor, $phone, $comment){
    global $email, $pdo;
    $date = date("d.m.y");
    $time = date("H:i:s");
    $checkoutInfo = "INSERT INTO cc_checkout (id, email, doorname, floor, phone, comment, date, time) VALUES(? , ? , ? , ? , ? , ? , ? , ?)";
    $stmtChekoutInfo = $pdo -> prepare($checkoutInfo);
    $stmtChekoutInfo -> execute([$id, $email, $doorname, $floor, $phone, $comment, $date, $time]);
    //UPDATE ORDERS OF USERS IN HOME PAGE... send cart values to orderBackendPanel with id from checkout and keep checkout as it is. get order together with same id (checkout, order)
    //cart fetch
    $sqlFetchCart = "SELECT email, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cc_cart WHERE email = ?";
    $stmtFetchCart = $pdo -> prepare($sqlFetchCart);
    $stmtFetchCart -> execute([$email]);
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
        $sqlInsert = "INSERT INTO cc_ordersBackendPanel (id, email, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
        $stmtInsertToBackend = $pdo -> prepare($sqlInsert);
        $stmtInsertToBackend -> execute([$id, $email, $coffee, $sugar, $sugarType, $milk, $cinnamon, $choco, $price, $qty]);
        //Insert to Users home.php
        $sqlInsertToUser = "INSERT INTO cc_orders (id, email, date, time, coffee, price, qty) VALUES ( ? , ? , ? , ? , ? , ? , ?)";
        $stmtInsertToUser = $pdo -> prepare($sqlInsertToUser);
        $stmtInsertToUser -> execute([$id, $email, $date, $time, $coffee, $price, $qty]);
    }
    if ($stmtFetchCart && $stmtChekoutInfo && $stmtInsertToBackend && $stmtInsertToUser) {
        return true;
    }
    else{
        return false;
    }
}
?>