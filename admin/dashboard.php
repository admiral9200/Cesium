<?php
session_start();
if (!isset($_SESSION['admin'])) {
    session_destroy();
        header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])){
  session_destroy();
  session_unset();
  header("location: index.php");
}
@include_once("./php/db.php");
$email = $_SESSION['admin'];
$sqlAdmin = "SELECT firstName, lastName FROM cc_admins WHERE email = ?";
$stmtAdmin = $pdo -> prepare($sqlAdmin);
$stmtAdmin -> execute([$email]);
$admin = $stmtAdmin -> fetch();
$firstName = $admin['firstName'];
$lastName = $admin['lastName'];
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
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>
    <body>
        <nav class="navbar container-fluid fixed-top">
          <div class="col-4">
            <a class="navbar-brand" href="dashboard.php">
              <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
          </div>
          <div class="col-4">
            <ul class="nav justify-content-center">
              <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="system.php">System</a>
              </li>
            </ul> 
          </div>
          <div class="row col-4 justify-content-end">
            <ul class="nav">
              <li class="dropdown">
                  <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName." ".$lastName; ?> <i class="far fa-user"></i></a>
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
          <?php
          $sqlNumberOfUsers = "SELECT COUNT(email) AS NumberOfUsers FROM cc_users";
          $stmtNumberOfUsers = $pdo -> prepare($sqlNumberOfUsers);
          $stmtNumberOfUsers -> execute();
          $NumberOfUsers = $stmtNumberOfUsers -> fetch();
          $sqlOrdersMade = "SELECT COUNT(id) AS NumberOfOrders FROM cc_checkout";
          $stmtOrdersMade = $pdo -> prepare($sqlOrdersMade);
          $stmtOrdersMade -> execute();
          $Ordersmade = $stmtOrdersMade -> fetch();
          $sqlAllOrders = "SELECT COUNT(DISTINCT id) AS NumberOfAllOrders FROM cc_orders";
          $stmtAllOrders = $pdo -> prepare($sqlAllOrders);
          $stmtAllOrders -> execute();
          $NumberOfAllOrders = $stmtAllOrders -> fetch();
          ?>
          <h6>Users registered: <?php echo $NumberOfUsers['NumberOfUsers']; ?></h6>
          <h6>Order Made: <?php echo $Ordersmade['NumberOfOrders']; ?></h6>
          <h6>All Orders Made in Platform: <?php echo $NumberOfAllOrders['NumberOfAllOrders']; ?></h6>
          <form method="POST" class="logout fixed-bottom">
            <button class="btn btn-danger btn-block" value="logout" name="logout"><i class="fas fa-sign-out-alt"></i></button>
          </form>
        </div>
        <script>
          $(document).ready(function(){    
              loadstation();
          });
          function loadstation(){
              $("#liveOrders").load("./php/liveOrders.php");
              setTimeout(loadstation, 1000);
          }
        </script>
        <div class="container main">
          <div class="row">
            <div class="col" id="liveOrders">
            </div>
          </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
        <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>