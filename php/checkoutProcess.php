<?php
session_start();
date_default_timezone_set('Europe/Athens');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Paypal Integration not working on localhost
    /* if(isset($_POST['payment']) == "paypal"){
        header("location: payment.php");
        die();
    } */
    include("db_connect.php");
    $email = $_SESSION['email'];
    if(isset($_POST['checkout'])){
        $date = date("d.m.y");
        $time = date("H:i:s");
        $stmtID = $pdo -> query("SELECT id FROM cc_id");
        $stmtID -> fetch();
        $id = "cc".$stmtID['id'];
        $doorname = $_POST['doorname'];
        $floor = $_POST['floor'];
        $phone = $_POST['phone'];
        $comment = $_POST['comment'];
        $payment = $_POST['payment'];
        $checkoutInfo = "INSERT INTO cc_checkout (id, email, doorname, floor, phone, comment, date, time) VALUES(? , ? , ? , ? , ? , ? , ? , ?)";
        $stmtChekoutInfo = $pdo -> prepare($checkoutInfo);
        $stmtChekoutInfo -> execute([$id, $email, $doorname, $floor, $phone, $comment, $date, $time]);
        //UPDATE ORDERS OF USERS IN HOME PAGE... send cart values to orderBackendPanel with id from checkout and keep checkout as it is. get order together with same id (checkout, order)
        //cart fetch
        $totalCost = $i = 0;
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
        //Update/Increase ID order number in id table
        $idNumber = $stmtID['id'];
        $idNumber++;
        $sqlIncID = "UPDATE cc_id SET id = ?";
        $stmtIncID = $pdo -> prepare($sqlIncID);
        $stmtIncID -> execute([$idNumber]);
        //Clear Cart after order placed
        $sqlClearCart = "DELETE FROM cc_cart WHERE email = ?";
        $stmtClearCart = $pdo -> prepare($sqlClearCart);
        $stmtClearCart -> execute([$email]);
        header("location: ../success.php");
    }
}
else{
    //handle error POST
}
?>