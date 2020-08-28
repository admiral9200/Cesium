<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
if (isset($_POST['add'])){
    $check_address_sum = "SELECT * FROM cc_address WHERE email = ?";
    $stmtCheckAddressesSum = $pdo -> prepare($check_address_sum);
    $stmtCheckAddressesSum -> execute([$email]);
    if ($stmtCheckAddressesSum -> rowCount() >= 2){
        $_SESSION['addresses'] = "Δεν μπορείτε να προσθέσετε άλλη διέυθυνση.";
        header("location: ../home.php");
    }
    else{
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $state = mysqli_real_escape_string($con, $_POST['state']);
        $add_address_query = "INSERT INTO cc_address (email, address, state) VALUES (? , ? , ?)";
        $stmtAddAddresses = $pdo -> prepare($add_address_query);
        $stmtAddAddresses -> execute([$email, $address, $state]);
        header("location: ../home.php");
    }
}
?>