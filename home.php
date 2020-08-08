<?php
include("db_connect.php");
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
    <link rel="stylesheet" type="text/css" href="./css/home.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
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
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Καλωσήρθες <?php if (isset($_SESSION['email'])) { echo $_SESSION['firstName']; } ?></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="profile.php">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1>Έχεις όρεξη για καφέ; Πρόσθεσε τη διεύθυνση σου και παράγγειλε!</h1>
                <form action="./php/address.php" method="POST">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Παράγγειλε τώρα</button>        
                </form>
            </div>
        </div>
    </div>
    <div class="container space">
        <!-- server side check form -->
        <form action="./php/add_address.php" class="form-group needs-validation" method="POST" novalidate>
            <div class="row">
                <div class="group col-5">
                    <input name="address" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου" required>
                    <div class="invalid-feedback">
                        Πρέπει να συμπληρώσεις την διεύθυνσή σου.
                    </div>
                </div>
                <div class="group col-5">
                    <input name="state" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την περιοχή σου" required>
                    <div class="invalid-feedback">
                        Πρέπει να συμπληρώσεις την περιοχή σου.
                    </div>
                </div>
                <div class="group col-2 sticky-top">
                    <button name="add" type="submit" class="btn btn-primary btn-lg">Προσθήκη</button>
                </div>
            </div>
        </form>
        <hr class="mt-5 mb-5">
        <h2 style="color: black !important;" class="mb-5">Οι διευθύνσεις μου</h2>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item mt-4 mb-4">
                        <div class="row">
                            <div class="col-3">
                                <h6>Διεύθυνση</h6>
                            </div>
                            <div class="col-3">
                                <h6>Περιοχή</h6>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item mt-2 mb-4">
                        <div class="row">
                            <div class="col-3">
                                <h6><?php if (isset($_SESSION['email'])) { echo $_SESSION['firstName']; } ?></h6>
                            </div>
                            <div class="col-3">
                                <h6>Νέα Ιωνία</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container space">
        <h2 style="color: black !important;" class="mb-5">Οι παραγγελίες μου</h2>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item mt-4 mb-4">
                        <div class="row">
                            <div class="col-3">
                                <h6>Κωδ. Παραγγελίας</h6>
                            </div>
                            <div class="col-3">
                                <h6>Ημερομηνία</h6>
                            </div>
                            <div class="col-3">
                                <h6>Περιεχόμενα</h6>
                            </div>
                            <div class="col-3">
                                <h6>Κόστος</h6>
                            </div>
                        </div>
                    </li>
                    <!-- DYNAMIC PHP PAST ORDERS-->
                    <li class="list-group-item mt-2 mb-4">
                        <div class="row">
                            <div class="col-3">
                                <h6>12797547</h6>
                            </div>
                            <div class="col-3">
                                <h6>25/07/20</h6>
                                <p>16:20:51</p>
                            </div>
                            <div class="col-3">
                                <h6>1x Freddo Cappuccino</h6>
                                <h6>1x Freddo Espresso</h6>
                            </div>
                            <div class="col-3">
                                <h6>1,50€</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container space">
        <div class="card-deck">
            <div class="card">
              <img src="./images/coffee1.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Πολλές Ποικιλίες</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              </div>
            </div>
            <div class="card">
              <img src="./images/coffee2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Πολύ Προσιτές Τιμές</h5>
                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="card">
              <img src="./images/coffee3.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Άμεση Εξυπηρέτηση</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
              </div>
            </div>
        </div>
    </div>
    <!-- SALE SECTION -->
    <?php echo file_get_contents("sale.html"); ?>
    <!-- Site footer -->
    <?php echo file_get_contents("footer.html"); ?>