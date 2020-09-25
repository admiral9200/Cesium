<?php
session_start();
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) header('location: ../');
if (!isset($_SESSION['success'])) header('location: ../home/');
unset($_SESSION['success']);
include("../php/db_connect.php");
$sqlLoggedInUser = "SELECT * FROM cc_users WHERE email = ?";
$resultUser = $pdo -> prepare($sqlLoggedInUser);
$resultUser -> execute([$email]);
$user = $resultUser -> fetch();
$firstName = $user['firstName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/success.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="icon" type="image/png" href="../images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="../home/">
                <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName; ?> <i class="far fa-user"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="../profile/">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container my-3">
        <div class="alert alert-success" role="alert">
            <div class="text-center">
                <img src="../images/success.png" class="rounded chk" alt="Success">
            </div>
            <h1 class="alert-heading space">Η παραγγελία σου θα παραδοθεί σε 15'</h1>
            <p class="text-center chk-p">Στο email σου θα βρεις όλα τα στοιχεία της παραγγελίας σου. Σε περίπτωση που θέλεις να αλλάξεις κάτι, κάλεσε μας.</p>
            <hr>
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-xl-6 col-12 pl-xl-4 pr-xl-4 p-0 text-center">
                        <h5>Διεύθυνση Παράδοσης</h5>
                        <p>
                            <?php
                            $finalQuery = "SELECT address FROM cc_address WHERE email = ?";
                            $stmtFinal = $pdo -> prepare($finalQuery);
                            $stmtFinal -> execute([$email]);
                            $row = $stmtFinal -> fetch();
                            echo $row['address'];
                            echo " - ";
                            $getFloorQuery = "SELECT floor, time FROM cc_checkout WHERE email = ? AND id IN (SELECT max(id) FROM cc_checkout WHERE email = ?)";
                            $resultGetFloorTime = $pdo -> prepare($getFloorQuery);
                            $resultGetFloorTime -> execute([$email, $email]);
                            $rowGetFloorTime = $resultGetFloorTime -> fetch();
                            echo $rowGetFloorTime['floor'];
                            echo "ος όροφος";
                            ?>
                        </p>
                    </div>
                    <div class="col-xl-6 col-12 pl-xl-4 pr-xl-4 p-0 text-center">
                        <h5>Ώρα Παραγγελίας</h5>
                        <p><?php echo $rowGetFloorTime['time']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---- Footer ----->
    <?php echo file_get_contents("../html/footer.html"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
</body>
</html>