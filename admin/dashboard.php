<?php
session_start();
if (!isset($_SESSION['email'])) {
    session_destroy();
    header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])){
  session_destroy();
  session_unset();
  header("location: index.php");
}
include_once("./php/db.php");
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
        <div class="container main">
          <div class="row">
            <div class="col">
            <?php
            $sqlCheckout = "SELECT * FROM cc_checkout";
            $stmtCheckout = $pdo -> prepare($sqlCheckout);
            $stmtCheckout -> execute();
            $sqlOrdersExists = "SELECT COUNT(id) AS OrdersExists FROM cc_ordersBackendPanel";
            $stmtOrdersExists = $pdo -> prepare($sqlOrdersExists);
            $stmtOrdersExists -> execute();
            if(($stmtCheckout -> rowCount() > 0) && ($stmtOrdersExists -> rowCount() > 0)){
              while($rowCheckout = $stmtCheckout -> fetch()){
                $id = $rowCheckout['id'];
                $email = $rowCheckout['email'];
                $sqlUserName = "SELECT firstName, lastName FROM cc_users WHERE email = ?";
                $stmtUserName = $pdo -> prepare($sqlUserName);
                $stmtUserName -> execute([$email]);
                $rowUserName = $stmtUserName -> fetch();
                $firstName = $rowUserName['firstName'];
                $lastName = $rowUserName['lastName'];
                $doorname = $rowCheckout['doorname'];
                $floor = $rowCheckout['floor'];
                $phone = $rowCheckout['phone'];
                $comment = $rowCheckout['comment'];
                $date = $rowCheckout['date'];
                $time = $rowCheckout['time'];
                ?>
                <div class="card mb-3">
                  <div class="card-body row">
                    <div class="col-1">
                      <p><?php echo $id; ?></p>
                    </div>
                    <div class="col-2">
                      <h6><?php echo $firstName." ".$lastName; ?></h6>
                      <p><?php echo $email; ?></p>
                    </div>
                    <div class="col-2">
                      <p><?php echo $doorname." ".$floor." - ".$phone; ?></p>
                      <p><?php echo $comment; ?></p>
                    </div>
                    <div class="col-1">
                      <p><?php echo $date; ?></p>
                      <p><?php echo $time; ?></p>
                    </div>
                    <div class="col-3">
                      <?php
                      $totalCost = 0;
                      $sqlBackendOrders = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cc_ordersBackendPanel WHERE id = ?";
                      $stmtOrdersPanel = $pdo -> prepare($sqlBackendOrders);
                      $stmtOrdersPanel -> execute([$id]);
                      while ($rowOrder = $stmtOrdersPanel -> fetch()) {
                        $coffee = $rowOrder['coffee'];
                        $sugar = $rowOrder['sugar'];
                        $sugarType = $rowOrder['sugarType'];
                        $milk = $rowOrder['milk'];
                        $cinnamon = $rowOrder['cinnamon'];
                        $choco = $rowOrder['choco'];
                        $price = $rowOrder['price'];
                        $totalCost += $price;
                        $qty = $rowOrder['qty'];
                        ?>
                          <h5 class="mb-0"><?php echo $qty."x ".$coffee ?></h5>
                          <p class="sz">
                            <?php echo $sugar.", ".$sugarType; 
                            if($milk == 1) echo ", Γάλα";
                            if($cinnamon == 1) echo ", Κάνελα";
                            if($choco == 1) echo ", Σκόνη Σοκολάτας";
                            ?>
                          </p>
                        <?php
                      }
                      ?>
                    </div>
                    <div class="col-1">
                      <h6>
                        <?php
                        $costString = sprintf("%0.2f", $totalCost);
                        echo $costString;
                        ?>
                      </h6>
                    </div>
                    <div class="col-2">
                      <form action="./php/deleteOrder.php" method="POST">
                        <button value="<?php echo $id; ?>" name="deleteOrder" class="btn btn-primary btn-lg btn-block">Execute</button>
                      </form>
                    </div>
                  </div>
                </div>
              <?php
              }
            }
            else{
              ?>
              <h1>Δεν υπάρχουν νέες παραγγελίες!</h1>
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