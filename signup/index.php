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
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    <link rel="stylesheet" type="text/css" href="/css/footer.css">
    <link rel="stylesheet" type="text/css" href="/css/signup.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap-4.5.0/css/bootstrap.min.css">
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script async src="/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script async src="signup.js"></script>
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="signUpBg">
        <nav class="navbar navbar-light container d-flex justify-content-center">
            <a class="navbar-brand" href="/">
                <img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
        </nav>
        <div id="registerForm" class="py-5 p-0">
            <div class="mx-auto col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 py-xl-4 py-lg-4 py-md-3 py-sm-2 p-0">
                <div class="login-snip text-white user-select-none">
                    <h1>Εγγραφή</h1>
                    <form>
                        <div class="login-space">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="group py-2">
                                        <label class="label">Email</label>
                                        <input id="email" type="email" class="input form-control border-0" placeholder="Γράψε τη Διέυθυνση Email" required>
                                        <div class="text-danger" id="warnEmail">Πρέπει να συμπληρώσεις το email σου.</div>
                                    </div>
                                    <div class="group py-2">
                                        <label class="label">Όνομα</label> 
                                        <input id="firstName" type="text" class="input form-control border-0" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
                                        <div class="text-danger">Πρέπει να συμπληρώσεις το όνομα σου</div>
                                    </div>
                                    <div class="group py-2">
                                        <label class="label">Επίθετο</label> 
                                        <input id="lastName" type="text" class="input form-control border-0" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
                                        <div class="text-danger">Πρέπει να συμπληρώσεις το επίθετο σου.</div>
                                    </div>                                           
                                    <div class="group py-2">
                                        <label class="label">Κινητό Τηλέφωνο</label> 
                                        <input id="mobile" type="tel" class="input form-control border-0" data-type="mobile" placeholder="Γράψε το κινητό σου" pattern="[0-9]{10}" required>
                                        <div class="text-danger">Πρέπει να συμπληρώσεις το κινητό σου.</div>
                                    </div>                                           
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="group py-2">
                                        <label class="label">Κωδικός</label> 
                                        <input id="password" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                        <div class="text-danger">Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.</div>
                                    </div>
                                    <div class="group py-2">
                                        <label class="label">Επαλήθευση Κωδικού</label> 
                                        <input id="passwordRetype" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε ξανά τον κωδικό σου" required>
                                        <div class="text-danger">Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.</div>
                                    </div>
                                    <div class="group py-2">
                                        <div class="custom-control custom-checkbox" style="cursor: pointer;">
                                            <label class="custom-control-label" for="termsAccept" style="cursor: pointer;">Αποδέχομαι τους όρους χρήσης</label>
                                            <input type="checkbox" class="custom-control-input" id="termsAccept" style="cursor: pointer;" required>
                                            <div class="text-danger">Πρέπει να αποδεχτείς τους όρους χρήσης.</div>
                                        </div>
                                    </div>
                                    <div class=" mt-4 py-2">
                                        <button type="button" class="btn btn-block text-white mainbtn" onclick="signUp()">Εγγραφή</button>
                                        <div id="response" class="d-flex justify-content-center pt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- SALE SECTION -->
    <?php echo file_get_contents("../views/sale.html"); ?>
    <!-- Newsletter -->
    <?php echo file_get_contents("../views/newsletter.html"); ?>
    <!-- Footer -->
    <?php echo file_get_contents("../views/footer.html"); ?>
</body>
</html>