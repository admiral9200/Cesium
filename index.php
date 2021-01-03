<?php
session_start();
if (isset($_SESSION['email'])) header("location: /home/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="icon" type="image/png" href="/images/chip_coffee.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bangers&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    <link rel="stylesheet" type="text/css" href="/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/css/form.css">
    <link rel="stylesheet" href="/bootstrap-4.5.0/css/bootstrap.min.css">
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script async src="/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script async src="/js/index.js"></script>
</head>
<body>
    <div class="row main m-0 p-0">
        <div class="bg d-flex flex-column col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 p-0 pb-md-5">
            <div class="left">
                <a class="logo_pos" href="/"><img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee"></a>
                <div class="content d-flex flex-column justify-content-center p-xl-0 p-lg-0 p-md-0 pt-5">
                    <h1>Παράγγειλε καφέ σε ένα 1'</h1>
                    <h2 class="mt-2">Φθηνά, γρήγορα και ηλεκτρονικά</h2>
                </div>
            </div>
        </div>
        <div class="right d-flex justify-content-center align-items-center col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 p-xl-5 p-lg-5 p-md-5 p-sm-5 p-0">
            <div class="overlayLogo">
                <img class="logoStyle" src="/images/chip_coffee.png">
            </div>
            <div class="login-snip user-select-none">
                <div class="d-flex justify-content-center">
                    <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" id="signin-tab" class="tab mr-3">Σύνδεση</label>
                    <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" id="signup-tab" class="tab ml-3">Εγγραφή</label>
                </div>
                <div class="login-space">
                    <div class="login form-check pl-0">
                        <form class="form-group">
                            <div class="group">
                                <label class="label">Email</label>
                                <input id="email" type="email" class="input form-control form-control-lg index" placeholder="Γράψε τη Διεύθυνση Email" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις το email σου.</div>
                            </div>
                            <div class="group">
                                <label class="label">Password</label>
                                <input id="pass" type="password" class="input form-control form-control-lg index" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις τον κωδικό σου.</div>
                            </div>
                            <div class="group">
                                <div class="custom-control custom-checkbox w-50" style="cursor: pointer;">
                                    <input type="checkbox" class="custom-control-input" id="rmbrme" style="cursor: pointer;">
                                    <label class="custom-control-label text-white" for="rmbrme" style="cursor: pointer;">Να με θυμάσαι</label>
                                </div>
                            </div>
                            <div class="group"> 
                                <button type="submit" class="button btn mainbtn btn-lg" id="login">Σύνδεση</button>
                                <div id="res" class="d-flex justify-content-center pt-2"></div>
                            </div>
                            <div class="hr mt-4 mb-4"></div>
                            <div class="text-center"> 
                                <a href="/reset/">Ξέχασες τον κωδικό σου?</a>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-form form-check pl-0">
                        <form id="signupForm" class="form-group">
                            <div class="group">
                                <label class="label">Email</label>
                                <input id="emailR" type="email" class="input form-control form-control-lg index" placeholder="Γράψε τη Διέυθυνση Email" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.</div>
                            </div>
                            <div class="group">
                                <label class="label">Όνομα</label> 
                                <input id="firstName" type="text" class="input form-control form-control-lg index" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις το όνομα σου</div>
                            </div>
                            <div class="group">
                                <label class="label">Επίθετο</label> 
                                <input id="lastName" type="text" class="input form-control form-control-lg index" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις το επίθετο σου.</div>
                            </div>
                            <div class="group">
                                <label class="label">Password</label> 
                                <input id="password" type="password" class="input form-control form-control-lg index" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                <div class="text-danger">Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.</div>
                            </div>                                            
                            <div class="group mt-4">
                                <button type="submit" class="button btn mainbtn btn-lg" id="signup">Εγγραφή</button>
                                <div id="resReg" class="d-flex justify-content-center pt-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container m-xl-auto m-lg-auto m-md-auto my-4 features h-25">
        <div class="row h-100 align-items-center">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 m-xl-0 m-lg-0 m-md-0 my-4">
            <i class="fas fa-truck mx-auto d-block mb-4" style="height: 60px; width: auto;"></i>
                <h2 class="text-center">Delivery only</h2>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 m-xl-0 m-lg-0 m-md-0 my-4">
                <i class="fab fa-paypal mx-auto d-block mb-4" style="height: 60px; width: auto;"></i>
                <h2 class="text-center">Paypal</h2>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 m-xl-0 m-lg-0 m-md-0 my-4">
                <i class="fas fa-credit-card mx-auto d-block mb-4" style="height: 60px; width: auto;"></i>
                <h2 class="text-center">Credit card</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid h-75 m-0 p-0 img-section text-center text-white">
        <div class="row h-100 m-0">
            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12 p-0 cc-left">
                <h1 class=" text-left ml-xl-5 ml-lg-5 ml-md-4 ml-0 art-left">Discover the blonde flavor at Chip Coffee</h1>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-0 cc-right h-100 d-flex justify-content-center align-items-center">
                <h1 class="w-50 art-right">Life, Liberty and the pursuit of perfect roast</h1> 
            </div>
        </div>
    </div>
    <!-- SALE SECTION -->
    <div class="sale w-100">
        <div class="container mt-5 mx-auto">
            <div class="row w-100">
                <div class="col-xl-8 col-lg-6 col-md-8 col-12">
                    <h1 class="card-title text-body">Chipαρε τον καφέ σου!</h1>
                    <h5 class="card-text text-body">Με κάθε εγγραφή για πρώτη φορά έχεις 1+1 καφέ δώρο της επιλογής σου.</h5>
                    <p class="text-body">Κατά το τέλος της παραγγελίας σου χρησιμοποιήσε τον κωδικό NEWCHIPCOFFEE για να ενεργοποιήσεις την προσφορά.</p>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-12 user-select-none">
                    <img src="/images/sale.png" class="sale-image">
                </div>
            </div>
        </div>
    </div>
    <!-- NEWSLETTER -->
    <div class="newsletter">
        <div class="container p-lg-5 p-md-4 p-4">
            <div class="h-100 d-flex justify-content-center align-items-center mb-5">
                <hr class="col-xl-4">
                <h3 class="col-xl-4 text-white text-center">Chip Coffee Newsletter</h3>
                <hr class="col-xl-4">
            </div>
            <div class="h-100 d-flex justify-content-center align-items-center row p-4">
                <h5 class="mx-xl-0 mx-lg-0 mx-5 w-25 text-white text-left col-xl-5 col-12">Κάνε εγγραφή τώρα για να λαμβάνεις νέες προσφορές μέσω email.</h5>
                <input type="email" class="subEmail form-control form-control-lg mx-3 mt-xl-0 mt-lg-0 mt-md-0 mt-3 col-xl-4 col-12" id="emailNewsletter" placeholder="Email" required>
                <button type="click" class="subButton btn mainbtn btn-lg index mt-xl-0 mt-lg-0 mt-md-0 mt-2 col-xl-2 col-12" id="subscribe">Εγγραφή</button>
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
                <li><a class="phone" href="tel: 210-27-69696"><i class="fa fa-phone"></i> 210-xxxxxxx</a></li>
                <li><a class="email" href="mailto: support@chipcoffee.gr"><i class="fa fa-envelope"></i> support@chipcoffee.gr</a></li>
                <li class="text-white">Η ομάδα μας είναι στη διάθεσή σου, κάθε μέρα, 07:00 - 03:00, για να σε βοηθήσει με οποιαδήποτε ερώτηση έχεις.</li>
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
            <div class="col-12">
                <p class="copyright-text text-muted text-center">&copy;2020 Chip Coffee. Handcrafted by z3r0Luck.</p>
            </div>
        </div>
        </div>
    </footer>
</body>
</html>