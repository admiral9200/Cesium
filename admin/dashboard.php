<?php
session_start();
include("./php/db.php");
if (!isset($_SESSION['email'])) {
    session_destroy();
    header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])){
  session_destroy();
  session_unset();
  header("location: index.php");
}
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Chip Coffee Back Office</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/dashboard.css">
        <link rel="icon" type="image/png" href="../images/chip_coffee.png">
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar container-fluid fixed-top">
          <div class="col-4">
            <a class="navbar-brand" href="#">
              <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
          </div>
          <div class="col-4">
            <ul class="nav justify-content-center">
              <li class="nav-item">
                <a class="nav-link active" href="#">Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">System</a>
              </li>
            </ul> 
          </div>
          <div class="row col-4 justify-content-end">
            <ul class="nav">
              <li class="dropdown">
                  <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin <i class="far fa-user"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item menu" href="#">Profile</a>
                    <a class="dropdown-item menu" href="#">Settings</a>
                  </div>
              </li>
            </ul>
          </div>
        </nav>
        <!-- Main Panel-->
        <div class="sidebar p-3">
          <h1>Stats</h1>
          <h6>User registered: 12049</h6>
          <h6>Order Made: 7043</h6>
          <h6>Order Made: 7043</h6>
          <h6>Order Made: 7043</h6> 
          <form method="POST" class="logout">
            <button class="btn btn-danger btn-block" value="logout" name="logout"><i class="fas fa-sign-out-alt"></i></button>
          </form>
        </div>
        <div class="container main">
          <div class="row">
            <div class="col">
            <?php
                for ($i=0; $i < 5; $i++) { 
                ?>
                <div class="card mb-3">
                  <div class="card-body row">
                    <div class="col-1">
                      <p>id</p>
                    </div>
                    <div class="col-2">
                      <h6>firstName lastName</h6>
                      <p>email</p>
                    </div>
                    <div class="col-2">
                      <p>doorname floor - phone</p>
                      <p>comments</p>
                    </div>
                    <div class="col-1">
                      <p>date</p>
                      <p>time</p>
                    </div>
                    <div class="col-3">
                      <h6>1x Freddo Cappuccino</h6>
                      <p>Glykos, Leuki Zaxari, kanela, sokolata</p>
                    </div>
                    <div class="col-1">
                      <h6>Cost</h6>
                    </div>
                    <div class="col-2">
                      <button class="btn btn-primary btn-lg btn-block">Execute</button>
                    </div>
                  </div>
                </div>
                <?php
                }
                ?>
            </div>
          </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"
        integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg=="
        crossorigin="anonymous"></script>
        <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>