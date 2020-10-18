<?php
session_start();
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) header('location: ../');
if (!isset($_SESSION['success'])) header('location: ../home/');
unset($_SESSION['success']);
include("../php/db_connect.php");
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
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
</head>
<body>
    <div class="main">
        <div class="background p-0 w-100">
            <nav class="navbar navbar-light container">
                <a class="navbar-brand" href="../home/">
                    <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
                </a>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="../profile/">Ο λογαριασμός μου</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../php/logout.php">Αποσύνδεση</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="success p-xl-0 p-lg-0 p-md-0 p-sm-4 p-4">
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
                            <p id="details"></p>
                        </div>
                        <div class="col-xl-6 col-12 pl-xl-4 pr-xl-4 p-0 text-center">
                            <h5>Ώρα Παραγγελίας</h5>
                            <p id="time"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---- Footer ----->
        <footer class="site-footer foot w-100">
            <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                <h6>Επικοινωνια</h6>
                <ul class="footer-links">
                    <li class="text-muted"><a class="phone" href="/"><i class="fa fa-phone"></i></a> 210-xxxxxxx</li>
                    <li class="text-muted"><a class="email" href="/"><i class="fa fa-envelope"></i></a> support@chipcoffee.gr</li>
                    <li class="text-muted">Η ομάδα μας είναι στη διάθεσή σου, κάθε μέρα, 07:00 - 03:00, για να σε βοηθήσει με οποιαδήποτε ερώτηση έχεις.</li>
                </ul>
                </div>
                <div class="col-xs-6 col-md-4">
                <h6>Χρησιμα</h6>
                <ul class="footer-links">
                    <li><a href="#">Ρυθμίσεις Cookies</a></li>
                    <li><a href="#">Όροι Χρήσης</a></li>
                    <li><a href="#">Πολιτική Προστασίας Δεδομένων</a></li>
                    <li><a href="#">Συχνές Ερωτήσεις</a></li>
                </ul>
                </div>
                <div class="col-xs-6 col-md-3">
                    <h6>Ακολουθησε το ChipCoffee στα social media!</h6>
                    <ul class="social-icons float-left">
                        <li><a class="facebook" href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>   
                    </ul>
                </div>
            </div>
            <hr>
            </div>
            <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                <p class="copyright-text text-muted">Copyright &copy; 2020 All Rights Reserved by <a href="#">Chip Coffee</a>.</p>
                </div>
            </div>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="succ.js"></script>
</body>
</html>