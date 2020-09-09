<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
$check_address_sum = "SELECT address FROM cc_address WHERE email = ?";
$stmtCheckAddressesSum = $pdo -> prepare($check_address_sum);
$stmtCheckAddressesSum -> execute([$email]);
if (isset($_POST['address']) && isset($_POST['state'])){
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
else{
    echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος.
              </div>";
}
$address = $stmtCheckAddressesSum -> fetch();
if (isset($_GET['address']) && $_GET['address'] == $address['address']){
    $address_to_delete = $_GET['address'];
    $sqlDeleteAddress = "DELETE FROM cc_address WHERE address = ?";
    $stmtDeleteAddress = $pdo -> prepare($sqlDeleteAddress);
    $stmtDeleteAddress -> execute([$address_to_delete]);
    $_SESSION['delete_message'] = true;
    header("location: ../home.php");
    //echo true;
}
else{
    echo false;
}
?>