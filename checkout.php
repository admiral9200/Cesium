<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
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
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
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
                  <a class="dropdown-item" href="home.php">Οι παραγγελίες μου</a>
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
        <form action="success.php" method="POST" class="needs-validation" novalidate>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 box">
                    <h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
                    <div class="row space">
                        <div class="col-md-8">
                            <label for="firstName">Όνομα στο κουδούνι *</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Όροφος *</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                    </div>
                    <div class="space">
                        <label for="address">Προαιρετικό τηλ. επικοινωνίας</label>
                        <input type="text" class="form-control" id="address">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Σχόλια διεύθυνσης</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
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
                        <!-- DYNAMIC PRODUCTS IN CART li -->
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">1x Cappuccino</h6>
                                <small class="text-muted">Μέτριος, Μαύρη ζάχαρη</small>
                            </div>
                            <span class="text-muted">0,70€</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">1x Freddo Cappuccino</h6>
                                <small class="text-muted">Γλυκός, Λευκή ζάχαρη</small>
                            </div>
                            <span class="text-muted">0,80€</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Promo code</h6>
                                <small>NEWCHIPCOFFEE</small>
                            </div>
                            <span class="text-success">-0,70€</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <h5>Κόστος</h5>
                            <h5>0,80€</h5>
                        </li>
                    </ul>
                    <div class="card p-2">
                            <div class="input-group">
                            <input type="text" class="form-control" placeholder="Promo code">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-secondary">Redeem</button>
                                </div>
                            </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block my-2" type="submit">Αποστολή Παραγγελίας</button>
                </div>
            </div>
        </form>
    </div>
    <!---------------------SALE SEcTi0N---------------------->
    <?php echo file_get_contents("sale.html"); ?>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("footer.html"); ?>