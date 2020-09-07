<?php
session_start();
if (isset($_SESSION['email'])) header("location: home.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="icon" type="image/png" href="./images/chip_coffee.png">
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="/www/">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
        </nav>
        <div class="container pb-xl-5 pt-xl-5">
            <div class="row">
                <div class="col-xl-7 col-12">
                    <h1>Παράγγειλε καφέ σε ένα 1'</h1>
                    <h3>Φθηνά, γρήγορα και ηλεκτρονικά</h3>
                </div>
                <div class="col-xl-5 col-12">
                    <div class="card">
                        <div class="login-box">
                            <div class="login-snip user-select-none"> 
                                <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Συνδεση</label>
                                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Εγγραφη</label>
                                <div class="login-space">
                                    <div class="form-group">
                                        <div class="login form-check pl-0">
                                            <form class="form-group">
                                                <div class="group">
                                                    <label for="user" class="label">ΔΙΕΥΘΥΝΣΗ EMAIL</label>
                                                    <input id="email" type="email" class="input form-control form-control-lg" placeholder="Γράψε τη Διέυθυνση Email" required>
                                                    <div id="eWarn" class="text-danger"></div>
                                                </div>
                                                <div class="group">
                                                    <label for="pass" class="label">ΚΩΔΙΚΟΣ</label>
                                                    <input id="pass" type="password" class="input form-control form-control-lg" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                                    <div id="pWarn" class="text-danger">
                                                        Πρέπει να συμπληρώσεις τον κωδικό σου.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <input id="check" name="rememberme" type="checkbox" class="check chk-box">
                                                    <label for="check" class="color"><span class="icon"></span> Να με θυμάσαι</label>
                                                </div>
                                                <div class="group"> 
                                                    <input type="submit" class="button btn btn-lg" id="login" value="Συνδεση">
                                                    <div id="res" class="d-flex justify-content-center pt-2"></div>
                                                </div>
                                                <div class="hr mt-4 mb-3"></div>
                                                <div class="foot"> 
                                                    <a href="reset.php">Ξέχασες τον κωδικό σου?</a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="sign-up-form form-check pl-0">
                                            <form id="signupForm" class="form-group">
                                                <div class="group">
                                                    <label for="emailR" class="label">ΔΙΕΥΘΥΝΣΗ EMAIL</label>
                                                    <input id="emailR" type="email" class="input form-control form-control-lg" placeholder="Γράψε τη Διέυθυνση Email" required>
                                                    <div class="text-danger">
                                                        Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="firstName" class="label">ΟΝΟΜΑ</label> 
                                                    <input id="firstName" type="text" class="input form-control form-control-lg" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
                                                    <div class="text-danger">
                                                        Πρέπει να συμπληρώσεις το όνομα σου
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="lastName" class="label">ΕΠΙΘΕΤΟ</label> 
                                                    <input id="lastName" type="text" class="input form-control form-control-lg" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
                                                    <div class="text-danger">
                                                        Πρέπει να συμπληρώσεις το επίθετο σου.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="password" class="label">ΚΩΔΙΚΟΣ</label> 
                                                    <input id="password" type="password" class="input form-control form-control-lg" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                                    <div class="text-danger">
                                                        Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.
                                                    </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo file_get_contents("./html/card.html"); ?>
    <!-- SALE SECTION -->
    <?php echo file_get_contents("./html/sale.html"); ?>
    <!-- Footer -->
    <?php echo file_get_contents("./html/footer.html"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="./js/index.js"></script>
</body>
</html>