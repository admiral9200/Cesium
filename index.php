<?php
session_start();
if (isset($_SESSION['email'])){
    header("location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png">
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
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
            <a class="navbar-brand" href="/www/">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
        </nav>
        <div class="container">
            <div class="row space">
                <div class="col-md-7 col-xs-6 col-sm-12">
                    <h1>Παράγγειλε καφέ σε ένα 1'</h1>
                    <h3>Φθηνά, γρήγορα και ηλεκτρονικά</h3>
                </div>
                <div class="col-md-5 col-xs-6 col-sm-12">
                    <div class="card">
                        <div class="login-box">
                            <div class="login-snip user-select-none"> 
                                <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Συνδεση</label>
                                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Εγγραφη</label>
                                <div class="login-space">
                                    <div class="form-group">
                                        <div class="login form-check pl-0">
                                            <form action="./php/login.php" class="form-group needs-validation" method="POST" novalidate>
                                                <div class="group">
                                                    <label for="user" class="label">ΔΙΕΥΘΥΝΣΗ EMAIL</label>
                                                    <input name="email" type="email" class="input form-control form-control-lg" placeholder="Γράψε τη Διέυθυνση Email" required>
                                                    <div class="invalid-feedback">
                                                        Πρέπει να συμπληρώσεις το email σου. Ίσως δεν έχεις γράψει σωστά το email.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="pass" class="label">ΚΩΔΙΚΟΣ</label>
                                                    <input name="pass" type="password" class="input form-control form-control-lg" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                                    <div class="invalid-feedback">
                                                        Πρέπει να συμπληρώσεις τον κωδικό σου.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <input id="check" name="rememberme" type="checkbox" class="check chk-box">
                                                    <label for="check" class="color"><span class="icon"></span> Να με θυμάσαι</label>
                                                </div>
                                                <div class="group"> 
                                                    <input type="submit" class="button btn btn-lg" name="login" value="Συνδεση">
                                                    <?php
                                                        if (isset($_SESSION['error'])){
                                                            $error = $_SESSION['error'];
                                                            echo "<p class='mt-3' style='color: red !important'>$error</p>";
                                                            unset($_SESSION['error']);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="foot"> 
                                                    <a href="reset.php">Ξέχασες τον κωδικό σου?</a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="sign-up-form form-check pl-0">
                                            <form action="./php/register.php" class="form-group needs-validation" method="POST" novalidate>
                                                <div class="group">
                                                    <label for="user" class="label">ΔΙΕΥΘΥΝΣΗ EMAIL</label>
                                                    <input name="email" type="email" class="input form-control form-control-lg" placeholder="Γράψε τη Διέυθυνση Email" required>
                                                    <div class="invalid-feedback">
                                                        Πρέπει να συμπληρώσεις μία έγκυρη διέυθυνση email.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="pass" class="label">ΟΝΟΜΑ</label> 
                                                    <input name="firstName" type="text" class="input form-control form-control-lg" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
                                                    <div class="invalid-feedback">
                                                        Πρέπει να συμπληρώσεις το όνομα σου
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="pass" class="label">ΕΠΙΘΕΤΟ</label> 
                                                    <input name="lastName" type="text" class="input form-control form-control-lg" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
                                                    <div class="invalid-feedback">
                                                        Πρέπει να συμπληρώσεις το επίθετο σου.
                                                    </div>
                                                </div>
                                                <div class="group">
                                                    <label for="pass" class="label">ΚΩΔΙΚΟΣ</label> 
                                                    <input name="pass" type="password" class="input form-control form-control-lg" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
                                                    <div class="invalid-feedback">
                                                        Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.
                                                    </div>
                                                </div>                                            
                                                <div class="group mt-4">
                                                    <input type="submit" class="button btn btn-lg" name="signup" value="Εγγραφη">
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
    <!-- Site footer -->
    <?php echo file_get_contents("./html/footer.html"); ?>