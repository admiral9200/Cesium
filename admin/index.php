<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chip Coffee Back Office</title>
    <link rel="icon" type="image/png" href="../images/chip_coffee.png">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <script>
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
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
    <div id="particles-js"></div>
    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-5 col-xl-4 text-center">
                <img src="../images/chip_coffee.png" class="logo" alt="Chip Coffee Logo">
                <h1 class="mb-5">Chip Coffee</h1>
                <form action="./php/login.php" class="container pl-3 pr-3 form-group needs-validation w-75" method="POST" novalidate>
                    <div class="form-group">
                        <input class="input form-control form-control-lg" name="email" placeholder="Email" type="email" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input class="input form-control form-control-lg" name="pass" placeholder="Password" type="password" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg btn-block" name="login">Login</button>
                    </div>
                    <?php
                        if (isset($_SESSION['error'])){
                            $error = $_SESSION['error'];
                            echo "<p class='mt-3' style='color: red !important'>$error</p>";
                            unset($_SESSION['error']);
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/particles.js"></script>
    <script src="./js/app.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>