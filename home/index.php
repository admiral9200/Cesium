<?php
session_start();
if (!isset($_SESSION['email'])) header("location: ../");
include("../php/db_connect.php");
$email = $_SESSION['email'];
$sqlLoggedInUser = "SELECT * FROM cc_users WHERE email = ?";
$resultUser = $pdo -> prepare($sqlLoggedInUser);
$resultUser -> execute([$email]);
$user = $resultUser -> fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=UTF-8>
    <meta http-equiv="content-type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/chip_coffee.png">
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="./">
                <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user['firstName']; ?> <i class="far fa-user"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="../profile/">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="mb-xl-5">Καλωσήρθες, <?php echo $user['firstName']; ?></h1>
                <div id="home"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id='false' class="m-3"></div>
        <h2 class="mb-2 mt-5">Οι διευθύνσεις μου</h2>
        <div class="col-12 px-xl-2 px-0" id="msg"></div>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item mt-4 mb-4">
                        <div class="row">
                            <div class="col-xl-3 col-6">
                                <h6>Διεύθυνση</h6>
                            </div>
                            <div class="col-xl-3 col-6">
                                <h6>Περιοχή</h6>
                            </div>
                        </div>
                    </li>
                    <div id="addresses"></div>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="mb-3 mt-5">Οι παραγγελίες μου</h2>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item mt-4 mb-4 formobile">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3">
                                <h6>Κωδ. Παραγγελίας</h6>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <h6>Ημερομηνία</h6>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <h6>Περιεχόμενα</h6>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <h6>Κόστος</h6>
                            </div>
                        </div>
                    </li>
                    <?php
                    $sqlOrders = "SELECT id, date, time FROM cc_orders WHERE email = ?";
                    $stmtOrders = $pdo -> prepare($sqlOrders);
                    $stmtOrders -> execute([$email]);
                    if ($stmtOrders -> rowCount() > 0){
                        $id = $date = $time = $qty = $coffee = array();
                        while($rowOrders = $stmtOrders -> fetch()) {
                            $id[] = $rowOrders['id'];
                            $date[] = $rowOrders['date'];
                            $time[] = $rowOrders['time'];
                        }
                        $ids = array_unique($id);
                        foreach($ids as $key => $val){
                            ?>
                            <li class='list-group-item mt-2 mb-4'>
                                <div class='row'>
                                    <div class='col-xl-3 col-lg-3 col-6 text-xl-left text-lg-left text-left'>
                                        <h6><?php echo $ids[$key]; ?></h6>
                                    </div>
                                    <div class='col-xl-3 col-lg-3 col-6 text-xl-left text-lg-left text-right'>
                                        <h6><?php echo $date[$key]; ?></h6>
                                        <p><?php echo $time[$key]; ?></p>
                                    </div>
                                    <div class='col-xl-3 col-lg-3 col-12'>
                                        <?php
                                        $sqlCPQ = "SELECT coffee, price, qty FROM cc_orders WHERE id = ?";
                                        $stmtCPQ = $pdo -> prepare($sqlCPQ);
                                        $stmtCPQ -> execute([$ids[$key]]);
                                        $totalCost = 0;
                                        while($rowCPQ = $stmtCPQ -> fetch()){
                                            $coffee = $rowCPQ['coffee'];
                                            $qty = $rowCPQ['qty'];
                                            $price = $rowCPQ['price'];
                                            $totalCost += $price;
                                            echo "<h6>".$qty."x ".$coffee."</h6>";
                                        }
                                        ?>
                                    </div>
                                    <div class='col-xl-3 col-lg-3 col-12 cost'>
                                        <h6>
                                            <?php
                                            $costString = sprintf("%0.2f", $totalCost);
                                            echo $costString;
                                            ?>
                                            €
                                        </h6>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                    }
                    else{
                        ?>
                        <li class='list-group-item mt-2 mb-4'>
                            <h6>Δεν υπάρχει καμία παραγγελία.</h6>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- CARD -->
    <?php echo file_get_contents("../html/card.html"); ?>
    <?php echo file_get_contents("../html/sale.html"); ?>
    <!-- Site footer -->
    <?php echo file_get_contents("../html/footer.html"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="home.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
</body>
</html>