<?php
session_start();
if (!isset($_SESSION['email'])) header("location: /");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=UTF-8>
    <meta http-equiv="content-type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/images/chip_coffee.png">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link rel="stylesheet" type="text/css" href="/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/css/home.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap-4.5.0/css/bootstrap.min.css">
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script async src="/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script async src="home.js"></script>
    <script async type="module">
        import { getProfile } from '../js/modules.js';
        (() => getProfile())();
    </script>
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="/">
                <img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="/profile/">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 id="wlcm" class="mb-xl-5">Καλωσήρθες, </h1>
                <div id="home" class="lds-dual-ring-sm d-flex justify-content-center"></div>
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
                    <div id="addresses" class="lds-dual-ring-sm-bl d-flex justify-content-center"></div>
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
                            <div class="col-xl-2 col-lg-3">
                                <h6>Κόστος</h6>
                            </div>
                        </div>
                    </li>
                    <?php
                    include("../php/db_connect.php");
                    $sqlOrders = "SELECT id, date, time FROM cc_orders WHERE email = ? ORDER BY id DESC";
                    $stmtOrders = $pdo -> prepare($sqlOrders);
                    $stmtOrders -> execute([$_SESSION['email']]);
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
                                    <div class='col-xl-3 col-lg-3 col-md-3 col-6 text-xl-left text-lg-left text-left my-auto'>
                                        <h6><?php echo $ids[$key]; ?></h6>
                                    </div>
                                    <div class='col-xl-3 col-lg-3 col-md-3 col-6 text-xl-left text-lg-left text-right my-auto'>
                                        <h6><?php echo $date[$key]; ?></h6>
                                        <p><?php echo $time[$key]; ?></p>
                                    </div>
                                    <div class='col-xl-3 col-lg-3 col-md-3 col-12 my-auto'>
                                        <?php
                                        $sqlProducts = "SELECT coffee, price, qty FROM cc_orders WHERE id = ?";
                                        $stmtProducts = $pdo -> prepare($sqlProducts);
                                        $stmtProducts -> execute([$ids[$key]]);
                                        $totalCost = 0;
                                        while($products = $stmtProducts -> fetch()){
                                            $totalCost += $products['price'];
                                            echo "<h6>".$products['qty']."x ".$products['coffee']."</h6>";
                                        }
                                        ?>
                                    </div>
                                    <div class='col-xl-1 col-lg-1 col-md-1 col-12 cost my-auto'>
                                        <h6>
                                            <?php
                                            $costString = sprintf("%0.2f", $totalCost);
                                            echo $costString;?>€
                                        </h6>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-12 my-auto">
                                        <button type="button" class="btn mainbtn btn-block text-white orderAgain" onclick="orderAgain('<?php echo $ids[$key]; ?>')">Παράγγειλε ξανά</button>
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
    <!-- SALE SECTION -->
    <?php echo file_get_contents("../views/sale.html"); ?>
    <!-- Newsletter -->
    <?php echo file_get_contents("../views/newsletter.html"); ?>
    <!-- Site footer -->
    <?php echo file_get_contents("../views/footer.html"); ?>
</body>
</html>