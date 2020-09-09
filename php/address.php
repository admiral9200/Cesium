<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
if (isset($_POST['address']) && isset($_POST['state'])){
    $check_address_sum = "SELECT * FROM cc_address WHERE email = ?";
    $stmtCheckAddressesSum = $pdo -> prepare($check_address_sum);
    $stmtCheckAddressesSum -> execute([$email]);
    if ($stmtCheckAddressesSum -> rowCount() >= 1){
        echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>Δε μπορείτε να προσθέσετε άλλη διεύθυνση.
              </div>";
    }
    else{
        $address = $_POST['address'];
        $state = $_POST['state'];
        $add_address_query = "INSERT INTO cc_address (email, address, state) VALUES (? , ? , ?)";
        $stmtAddAddresses = $pdo -> prepare($add_address_query);
        $stmtAddAddresses -> execute([$email, $address, $state]);
        echo true;
    }
}
if (isset($_GET['address'])){
    $address_to_delete = $_GET['address'];
    $sqlDeleteAddress = "DELETE FROM cc_address WHERE address = ?";
    $stmtDeleteAddress = $pdo -> prepare($sqlDeleteAddress);
    $stmtDeleteAddress -> execute([$address_to_delete]);
    $_SESSION['delete_message'] = true;
    header("location: ../home.php");
}
else{
    echo false;
}
?>