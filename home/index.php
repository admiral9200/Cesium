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
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['firstName']; ?> <i class='far fa-user'></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="/profile/">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 id="wlcm" class="mb-xl-5">Καλωσήρθες, <?php echo $_SESSION['firstName']; ?></h1>
                <div id="home" class="lds-dual-ring-sm d-flex justify-content-center"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id='false' class="m-3"></div>
        <div class="row">
            <div class="group col-xl-5 col-12 mt-2 m-xl-0">   
                <input id="address" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου" required>
                <div class="text-danger">
                    Πρέπει να συμπληρώσεις την διεύθυνσή σου.
                </div>
            </div>
            <div class="group col-xl-5 col-12 mt-2 m-xl-0">
                <input id="state" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την περιοχή σου" required>
                <div class="text-danger">
                    Πρέπει να συμπληρώσεις την περιοχή σου.
                </div>
            </div>
            <div class="group col-xl-2 col-12 mt-2 m-xl-0">
                <button onclick="addAddress()" type="button" class="btn mainbtn btn-lg btn-block text-white">Προσθήκη</button>
            </div>
        </div>
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
                <ul class="list-group list-group-flush" id="orders">
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