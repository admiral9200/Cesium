<?php
session_start();
if (isset($_SESSION['email'])) header("location: ./home/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="icon" type="image/png" href="./images/chip_coffee.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap">
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/base.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="row main m-0 p-0">
        <div class="bg d-flex flex-column col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 p-0">
            <div class="left">
                <a class="logo_pos" href="./"><img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee"></a>
                <div class="content d-flex flex-column justify-content-center p-xl-0 p-lg-0 p-md-0 pt-5">
                    <h1>Παράγγειλε καφέ σε ένα 1'</h1>
                    <h3 class="mt-2">Φθηνά, γρήγορα και ηλεκτρονικά</h3>
                </div>
            </div>
        </div>
        <div class="right d-flex justify-content-center align-items-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 p-xl-5 p-lg-5 p-md-5 p-sm-5 p-0">
            <div class="login-snip user-select-none"> 
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Συνδεση</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Εγγραφη</label>
                <div class="login-space">
                    <div class="login form-check pl-0">
                        <form class="form-group">
                            <div class="group">
                                <label for="user" class="label">ΔΙΕΥΘΥΝΣΗ EMAIL</label>
                                <input id="email" type="email" class="input form-control form-control-lg" placeholder="Γράψε τη Διεύθυνση Email" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις το email σου.</div>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">ΚΩΔΙΚΟΣ</label>
                                <input id="pass" type="password" class="input form-control form-control-lg" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις τον κωδικό σου.</div>
                            </div>
                            <div class="group">
                                <input id="check" type="checkbox" class="check chk-box">
                                <label for="check" class="color"><span class="icon"></span> Να με θυμάσαι</label>
                            </div>
                            <div class="group"> 
                                <input type="submit" class="button btn btn-lg" id="login" value="Συνδεση">
                                <div id="res" class="d-flex justify-content-center pt-2"></div>
                            </div>
                            <div class="hr mt-4 mb-3"></div>
                            <div class="text-center"> 
                                <a href="./reset/">Ξέχασες τον κωδικό σου?</a>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-form form-check pl-0">
                        <form id="signupForm" class="form-group">
                            <div class="group">
                                <label for="emailR" class="label">ΔΙΕΥΘΥΝΣΗ EMAIL</label>
                                <input id="emailR" type="email" class="input form-control form-control-lg" placeholder="Γράψε τη Διέυθυνση Email" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.</div>
                            </div>
                            <div class="group">
                                <label for="firstName" class="label">ΟΝΟΜΑ</label> 
                                <input id="firstName" type="text" class="input form-control form-control-lg" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις το όνομα σου</div>
                            </div>
                            <div class="group">
                                <label for="lastName" class="label">ΕΠΙΘΕΤΟ</label> 
                                <input id="lastName" type="text" class="input form-control form-control-lg" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις το επίθετο σου.</div>
                            </div>
                            <div class="group">
                                <label for="password" class="label">ΚΩΔΙΚΟΣ</label> 
                                <input id="password" type="password" class="input form-control form-control-lg" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.</div>
                            </div>                                            
                            <div class="group mt-4">
                                <input type="submit" class="button btn btn-lg" id="signup" value="Εγγραφη">
                                <div id="resReg" class="d-flex justify-content-center pt-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-xl-5 my-lg-5 py-xl-4 py-lg-4 my-3">
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
    <div class="card sale w-100">
        <div class="container card-img-overlay">
            <div class="row">
                <div class="col-xl-8 col-lg-6 col-md-8 col-12">
                    <h2 class="card-title text-body">Chipαρε τον καφέ σου!</h2>
                    <h5 class="card-text text-body">Με κάθε εγγραφή για πρώτη φορά έχεις 1+1 καφέ δώρο της επιλογής σου.</h5>
                    <p class="text-body">Κατά το τέλος της παραγγελίας σου χρησιμοποιήσε τον κωδικό NEWCHIPCOFFEE για να ενεργοποιήσεις την προσφορά.</p>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-12 user-select-none">
                    <img src="./images/sale.png" alt="Sale">
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="site-footer">
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="./js/index.js"></script>
</body>
</html>