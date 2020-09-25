<?php
session_start();
include("../php/db_connect.php");
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) header("location: /www/");
$sqlCheckIfCartIsEmpty = "SELECT email FROM cc_cart WHERE email = ?";
$isCartEmpty = $pdo -> prepare($sqlCheckIfCartIsEmpty);
$isCartEmpty -> execute([$email]);
if ($isCartEmpty -> rowCount() == 0) header("location: ../order/");
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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/checkout.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../images/chip_coffee.png" size="20x20">
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="../home/">
                <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName; ?> <i class="far fa-user"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="../profile.php">Ο λογαριασμός μου</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="container space">
            <h1>Ολοκλήρωση Παραγγελίας</h1>
        </div>
    </div>
    <div id="false" class="container m-3"></div>
    <div class="container space">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
                <h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
                <div class="row">
                    <div class="col-xl-8 col-12">
                        <label for="doorbell">Όνομα στο κουδούνι *</label>
                        <input type="text" class="form-control" id="doorname" required>
                        <div class="text-danger">
                                Πρέπει να συμπληρώσεις όνομα στο κουδούνι.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="floor">Όροφος *</label>
                        <input type="number" class="form-control" id="floor" required>
                        <div class="text-danger">
                                Πρέπει να συμπληρώσεις τον όροφο.
                        </div>
                    </div>
                </div>
                <div class="space">
                    <label for="address">Προαιρετικό τηλ. επικοινωνίας</label>
                    <input type="number" class="form-control" id="phone">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Σχόλια διεύθυνσης</label>
                    <textarea class="form-control" id="comment" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
                <h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
                <div class="form-group">
                    <div class="d-block mt-4">
                        <div class="list-group form-check">
                            <input class="form-check-input" type="radio" name="payment" value="credit" id="card" required/>
                            <label class="list-group-item form-check-label" for="card">Πιστωτική/Χρεωστική Κάρτα</label>
                            <input class="form-check-input" type="radio" name="payment" value="paypal" id="paypal" required/>
                            <label class="list-group-item form-check-label" for="paypal">PayPal</label>
                            <div class="text-danger" id="payment">
                                Πρέπει να διαλέξεις έναν τρόπο πληρωμής.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
                <h4 class="d-flex justify-content-between align-items-center mb-4">3. Ολοκλήρωση</h4>
                <ul class="list-group mb-1">
                    <?php
                    $cart_query = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cc_cart WHERE email = ?";
                    $stmtCart = $pdo -> prepare($cart_query);
                    $stmtCart -> execute([$email]);
                    $totalCost = 0;
                    while($rowCart = $stmtCart -> fetch()){
                        $coffee = $rowCart['coffee'];
                        $sugar = $rowCart['sugar'];
                        $sugarType = $rowCart['sugarType'];
                        $milk = $rowCart['milk'];
                        $cinnamon = $rowCart['cinnamon'];
                        $choco = $rowCart['choco'];
                        $price = $rowCart['price'];
                        $quantity = $rowCart['qty'];
                        $totalCost += $price;
                        echo "<li class='list-group-item d-flex justify-content-between lh-condensed'>
                                <div>
                                    <h6 class='my-0'>".$quantity."x $coffee</h6>
                                    <small class='text-muted'>
                                    ".$sugar.", ".$sugarType."";
                                    if($milk == 1){
                                        echo ", Γάλα";
                                    }
                                    if($cinnamon == 1){
                                        echo ", Κανέλα";
                                    }
                                    if($choco == 1){
                                        echo ", Σκόνη Σοκολάτας";
                                    }
                                    echo "</small>
                                    </div>
                                <span class='text-muted'>".$price."€</span>
                            </li>";
                    }
                    ?>
                    <!-- PROMO CODE -->
                    <!-- <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>NEWCHIPCOFFEE</small>
                        </div>
                        <span class="text-success">-0,70€</span>
                    </li> -->
                    <li class="list-group-item d-flex justify-content-between">
                        <h5>Κόστος</h5>
                        <h5><?php $costString = sprintf("%0.2f", $totalCost); $_SESSION['itemAmount'] = $costString; echo $costString; ?>€</h5>
                    </li>
                </ul>
                <!-- <div class="card p-2">
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary">Εξαργύρωση</button>
                        </div>
                    </div>
                </div> -->
                <button class="btn btn-primary btn-lg btn-block my-2" type="button" id="checkout" value="order">Αποστολή Παραγγελίας</button>
            </div>
        </div>
    </div>
    <!---------------------SALE SEcTi0N---------------------->
    <?php echo file_get_contents("../html/sale.html"); ?>
    <!-------------------- Site footer ---------------------->
    <?php echo file_get_contents("../html/footer.html"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="checkout.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
</body>
</html>