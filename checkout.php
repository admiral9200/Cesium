<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['checkout'])){
        header("location: success.php");
    }
    //CHECK WHAT PAYMENT USED PAYPAL isset or CREDIT isset...
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/order.css">
    <link rel="stylesheet" type="text/css" href="./css/checkout.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="home.php">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if (isset($_SESSION['email'])) { echo $_SESSION['firstName']; } ?></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="profile.php">Ο λογαριασμός μου</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="container space">
            <h1>Ολοκλήρωση Παραγγελίας</h1>
        </div>
    </div>
    <div class="container-fluid space order">
        <form action="" method="POST" class="needs-validation" novalidate>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 box">
                    <h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
                    <div class="row space">
                        <div class="col-md-8">
                            <label for="firstName">Όνομα στο κουδούνι *</label>
                            <input type="text" class="form-control" name="firstName" required>
                            <div class="invalid-feedback">
                                    Πρέπει να συμπληρώσεις όνομα στο κουδούνι.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Όροφος *</label>
                            <input type="number" class="form-control" name="lastName" required>
                            <div class="invalid-feedback">
                                    Πρέπει να συμπληρώσεις τον όροφο.
                            </div>
                        </div>
                    </div>
                    <div class="space">
                        <label for="address">Προαιρετικό τηλ. επικοινωνίας</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Σχόλια διεύθυνσης</label>
                        <textarea class="form-control" name="comment" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
                    </div>
                </div>
                <div class="col-md-4 box">
                    <h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
                    <div class="form-group">
                        <div class="d-block mt-4">
                            <div class="list-group form-check">
                                <input class="form-check-input" type="radio" name="RadioInputName" value="Value1" id="card" required/>
                                <label class="list-group-item form-check-label" for="card">Πιστωτική/Χρεωστική Κάρτα</label>
                                <input class="form-check-input" type="radio" name="RadioInputName" value="Value2" id="paypal" required/>
                                <label class="list-group-item form-check-label" for="paypal">PayPal</label>
                                <div class="invalid-feedback">
                                    Πρέπει να διαλέξεις έναν τρόπο πληρωμής.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 box">
                    <h4 class="d-flex justify-content-between align-items-center mb-4">3. Ολοκλήρωση</h4>
                    <ul class="list-group mb-1">
                        <?php
                        include("./php/db_connect.php");
                        $email = $_SESSION['email'];
                        $cart_query = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cart WHERE email = '$email'";
                        $result_cart = mysqli_query($con, $cart_query);
                        $totalCost = 0;
                        while($rowCart = mysqli_fetch_array($result_cart, MYSQLI_ASSOC)){
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
                            <h5><?php $costString = sprintf("%0.2f", $totalCost); echo $costString; ?>€</h5>
                        </li>
                    </ul>
                    <div class="card p-2">
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary">Εξαργύρωση</button>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block my-2" type="submit" name="checkout">Αποστολή Παραγγελίας</button>
                </div>
            </div>
        </form>
    </div>
    <!---------------------SALE SEcTi0N---------------------->
    <?php echo file_get_contents("./html/sale.html"); ?>
    <!-------------------- Site footer ---------------------->
    <?php echo file_get_contents("./html/footer.html"); ?>