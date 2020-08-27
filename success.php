<?php
session_start();
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
include("./php/db_connect.php");
$sqlLoggedInUser = "SELECT * FROM cc_users WHERE email = '$email'";
$resultUser = mysqli_query($con, $sqlLoggedInUser);
$rowUser = $resultUser -> fetch_array(MYSQLI_ASSOC);
$firstName = $rowUser['firstName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/success.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="home.php">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName; ?></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="profile.php">Ο λογαριασμός μου</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container space">
        <div class="alert alert-success" role="alert">
            <div class="text-center">
                <img src="./images/success.png" class="rounded chk" alt="Success">
            </div>
            <h1 class="alert-heading space">Η παραγγελία σου θα παραδοθεί σε 15'</h1>
            <p class="text-center chk-p">Στο email σου θα βρεις όλα τα στοιχεία της παραγγελίας σου. Σε περίπτωση που θέλεις να αλλάξεις κάτι, κάλεσε μας.</p>
            <hr>
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-6 text-center">
                        <h5>Διεύθυνση Παράδοσης</h5>
                        <p>
                            <?php
                            $finalQuery = "SELECT address FROM cc_address WHERE email = '$email'";
                            $resultFinal = mysqli_query($con, $finalQuery);
                            $row = mysqli_fetch_assoc($resultFinal);
                            echo $row['address'];
                            echo " - ";
                            $getFloorQuery = "SELECT floor, time FROM cc_checkout WHERE email = '$email' AND id IN (SELECT max(id) FROM cc_checkout WHERE email = '$email')";
                            $resultGetFloorTime = mysqli_query($con, $getFloorQuery);
                            $rowGetFloorTime = $resultGetFloorTime -> fetch_array(MYSQLI_ASSOC);
                            echo $rowGetFloorTime['floor'];
                            echo "ος όροφος";
                            ?>
                        </p>
                    </div>
                    <div class="col-6 text-center">
                        <h5>Ώρα Παραγγελίας</h5>
                        <p><?php echo $rowGetFloorTime['time']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("./html/footer.html"); ?>