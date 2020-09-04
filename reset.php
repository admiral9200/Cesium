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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="/www/">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
        </nav>
    </div>
    <div class="container space">
        <div class="form-gap">
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Ξέχασες τον κωδικό σου?</h2>
                                <p>Μπορείς να τον επαναφέρεις με το email σου.</p>
                                <div class="panel-body">
                                    <form id="register-form" role="form" autocomplete="off" class="form" action="newpass.html">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="Διεύθυνση email" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Συνέχεια" type="submit">
                                        </div>
                                        <input type="hidden" class="hide" name="token" id="token" value=""> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------- Site footer --------------------------->
    <footer class="site-footer fixed-bottom">
    <div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-5">
        <h6>Επικοινωνια</h6>
        <ul class="footer-links">
            <li><a class="phone" href="/"><i class="fa fa-phone"></i></a> 210-xxxxxxx</li>
            <li><a class="email" href="/"><i class="fa fa-envelope"></i></a> support@chipcoffee.gr</li>
            <li>Η ομάδα μας είναι στη διάθεσή σου, κάθε μέρα, 07:00 - 03:00, για να σε βοηθήσει με οποιαδήποτε ερώτηση έχεις.</li>
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
        <p class="copyright-text">Copyright &copy; 2020 All Rights Reserved by <a href="#">Chip Coffee</a>.</p>
        </div>
    </div>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"
        integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg=="
        crossorigin="anonymous"></script>
</body>
</html>