<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chip Coffee Back Office</title>
    <link rel="icon" type="image/png" href="../images/chip_coffee.png">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div id="particles-js"></div>
    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-4 text-center">
                <img src="../images/chip_coffee.png" class="logo" alt="Chip Coffee Logo">
                <h1 class="mb-5">Chip Coffee</h1>
                <form class="form-group mx-auto pl-3 pr-3">
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="email" placeholder="Email" type="email">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="pass" placeholder="Password" type="password">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg btn-block" id="login">Login</button>
                    </div>
                    <div id="res" class="d-flex justify-content-center pt-2"></div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="./js/particles.js"></script>
    <script src="./js/app.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>