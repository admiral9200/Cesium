<?php
session_start();
date_default_timezone_set('Europe/Athens');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    include("db_connect.php");
    $email = $_SESSION['email'];
    $date = date("d.m.y");
    $time = date("H:i:s");
    if(isset($_POST['checkout'])){
        $doorname = $_POST['doorname'];
        $floor = $_POST['floor'];
        $phone = $_POST['phone'];
        $comment = $_POST['comment'];
        $payment = $_POST['payment'];
        $checkoutInfo = "INSERT INTO checkout (email, doorname, floor, phone, comment, date, time) VALUES('$email', '$doorname', '$floor', '$phone', '$comment', '$date', '$time')";
        mysqli_query($con, $checkoutInfo);
        //UPDATE ORDERS OF USERS IN HOME PAGE
        $updateOrdersPage = "";
        header("location: ../success.php");
    }
}
else{
    //handle error POST
}
?>