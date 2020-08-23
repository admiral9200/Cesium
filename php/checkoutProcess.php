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
        $id = $rowID['id'];
        $doorname = $_POST['doorname'];
        $floor = $_POST['floor'];
        $phone = $_POST['phone'];
        $comment = $_POST['comment'];
        $payment = $_POST['payment'];
        $checkoutInfo = "INSERT INTO checkout (email, doorname, floor, phone, comment, date, time) VALUES('$email', '$doorname', '$floor', '$phone', '$comment', '$date', '$time')";
        mysqli_query($con, $checkoutInfo);
        //UPDATE ORDERS OF USERS IN HOME PAGE... send cart values to orderBackendPanel with id from checkout and keep checkout as it is. get order together with same id (checkout, order)
        $updateOrdersPage = "";
        header("location: ../success.php");
    }
}
else{
    //handle error POST
}
?>