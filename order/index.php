<?php
session_start();
@include_once("../config/db.connect.php");
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) header('location: /');
if ($_SESSION['addressExists'] == 0) header("location: ../home/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link rel="stylesheet" type="text/css" href="/css/order.css">
    <link rel="stylesheet" type="text/css" href="/css/footer.css">
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="/images/chip_coffee.png" size="20x20">
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script async src="/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script async src="order.js"></script>
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="background">
        <nav class="navbar navbar-light container"> 
            <a class="navbar-brand" href="/home/">
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
        <div class="container py-3">
            <h1>Διάλεξε τον καφέ που θες</h1>
        </div>
    </div>
    <div class="container">
        <div id="false"></div>
        <div class="row">
            <div class="col-12 col-xl-9 order-1 order-xl-0 coffees">
                <div id="info"></div>
                <div class="accordion" id="coffeesCatalog"></div>
            </div>
            <div class="col-xl-3 col-12 order-0 order-xl-1">
                <div class="card sticky-top cart" id="cart"></div>
            </div>
        </div>
    </div>
    <!--------------------- SALE SECTION ---------------------->
    <?php echo file_get_contents("../views/sale.html"); ?>
    <!-- Newsletter -->
    <?php echo file_get_contents("../views/newsletter.html"); ?>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("../views/footer.html"); ?>
</body>
</html>