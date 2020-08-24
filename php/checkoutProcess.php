<?php
session_start();
date_default_timezone_set('Europe/Athens');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    include("db_connect.php");
    $email = $_SESSION['email'];
    if(isset($_POST['checkout'])){
        $date = date("d.m.y");
        $time = date("H:i:s");
        $sql_id = "SELECT id FROM id";
        $resID = mysqli_query($con, $sql_id);
        $rowID = mysqli_fetch_assoc($resID);
        $id = "cc".$rowID['id'];
        $_SESSION['id'] = $id;
        $doorname = $_POST['doorname'];
        $floor = $_POST['floor'];
        $phone = $_POST['phone'];
        $comment = $_POST['comment'];
        $payment = $_POST['payment'];
        $checkoutInfo = "INSERT INTO checkout (id, email, doorname, floor, phone, comment, date, time) VALUES('$id', '$email', '$doorname', '$floor', '$phone', '$comment', '$date', '$time')";
        mysqli_query($con, $checkoutInfo);
        //UPDATE ORDERS OF USERS IN HOME PAGE... send cart values to orderBackendPanel with id from checkout and keep checkout as it is. get order together with same id (checkout, order)
        //cart fetch
        $totalCost = $i = 0;
        $fetchCart_sql = "SELECT email, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cart WHERE email = '$email'";
        $resultFetchCart = mysqli_query($con, $fetchCart_sql);
        $fetchCart = $resultFetchCart -> fetch_all(MYSQLI_ASSOC);
        foreach($fetchCart as $rowInsertToBackend){
            $coffee = $rowInsertToBackend['coffee'];
            $sugar = $rowInsertToBackend['sugar'];
            $sugarType = $rowInsertToBackend['sugarType'];
            $milk = $rowInsertToBackend['milk'];
            $cinnamon = $rowInsertToBackend['cinnamon'];
            $choco = $rowInsertToBackend['choco'];
            $price = $rowInsertToBackend['price'];
            $qty = $rowInsertToBackend['qty'];
            //Insert to Backend Panel for process order
            $sqlInsert = "INSERT INTO ordersBackendPanel (id, email, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty) VALUES ('$id', '$email', '$coffee', '$sugar', '$sugarType', '$milk', '$cinnamon', '$choco', '$price', '$qty')";
            mysqli_query($con, $sqlInsert);
            //Insert to Users home.php
            $sqlinsertToUser = "INSERT INTO orders (id, email, date, time, coffee, price, qty) VALUES ('$id', '$email', '$date', '$time', '$coffee', '$price', '$qty')";
            mysqli_query($con, $sqlinsertToUser);
        }
        $idNumber = $rowID['id'];
        $idNumber++;
        echo $idNumber;
        $sqlIncID = "UPDATE id SET id = '$idNumber'";
        mysqli_query($con, $sqlIncID);
        header("location: ../success.php");
    }
}
else{
    //handle error POST
}
?>