<?php
include("./php/db_connect.php");
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/home.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
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
            <a class="navbar-brand" href="home.php">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if (isset($_SESSION['email'])) { echo $_SESSION['firstName']; } ?></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="profile.php">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <?php
        $email = $_SESSION['email'];
        $addresses_query = "SELECT * FROM address WHERE email='$email'";
        $result = mysqli_query($con, $addresses_query);
        ?>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1>Έχεις όρεξη για καφέ; Πρόσθεσε τη διεύθυνση σου και παράγγειλε!</h1>
                <button class="btn btn-primary btn-lg btn-block" role="button" onclick="location.href='order.php'" <?php if(mysqli_num_rows($result) == 0){ echo "style='cursor: not-allowed' disabled"; } ?>>Παράγγειλε τώρα</button>        
            </div>
        </div>
    </div>
    <div class="container space">
        <form action="./php/add_address.php" class="form-group needs-validation" method="POST" novalidate>
            <div class="row">
                <div class="group col-5">   
                    <input name="address" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου" required>
                    <div class="invalid-feedback">
                        Πρέπει να συμπληρώσεις την διεύθυνσή σου.
                    </div>
                </div>
                <div class="group col-5">
                    <input name="state" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την περιοχή σου" required>
                    <div class="invalid-feedback">
                        Πρέπει να συμπληρώσεις την περιοχή σου.
                    </div>
                </div>
                <div class="group col-2 sticky-top">
                    <button name="add" type="submit" class="btn btn-primary btn-lg">Προσθήκη</button>
                </div>
            </div>
        </form>
        <?php
        if (isset($_SESSION['addresses'])){
            $message = $_SESSION['addresses'];
            echo "<p class='mt-3' style='color: red !important'>$message</p>";
            unset($_SESSION['addresses']);
        }
        ?>
        <hr class="mt-5 mb-5">
        <h2 style="color: black !important;" class="mb-5">Οι διευθύνσεις μου</h2>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item mt-4 mb-4">
                        <div class="row">
                            <div class="col-3">
                                <h6>Διεύθυνση</h6>
                            </div>
                            <div class="col-3">
                                <h6>Περιοχή</h6>
                            </div>
                        </div>
                    </li>
                    <?php
                    if (isset($_SESSION['delete_message'])){
                        $delete_message = $_SESSION['delete_message'];
                        echo "<div class='alert alert-danger alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                $delete_message
                            </div>";
                        unset($_SESSION['delete_message']);
                    }
                    if (mysqli_num_rows($result) > 0){
                        $i = 0;
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            $address = $_SESSION['address'] = $row['address'];
                            $state = $row['state'];
                            echo "<li class='list-group-item mt-2 mb-3'>
                                    <div class='row '>
                                        <div class='col-3 align-middle'>
                                            <h6>$address</h6>
                                        </div>
                                        <div class='col-3 align-middle'>
                                            <h6>$state</h6>
                                        </div>
                                        <div class='col-3'>
                                            <a class='btn btn-primary btn-danger' href='./php/delete.php?address=".$_SESSION['address']."' role='button'>Διαγραφή</a>
                                        </div>
                                    </div>
                                </li>";
                            $i += 1;
                        }
                    }
                    else{
                        echo "<li class='list-group-item mt-2 mb-4'>
                                <h6>Δεν υπάρχει ενεργή διεύθυνση</h6>
                              </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container space">
        <h2 style="color: black !important;" class="mb-5">Οι παραγγελίες μου</h2>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item mt-4 mb-4">
                        <div class="row">
                            <div class="col-3">
                                <h6>Κωδ. Παραγγελίας</h6>
                            </div>
                            <div class="col-3">
                                <h6>Ημερομηνία</h6>
                            </div>
                            <div class="col-3">
                                <h6>Περιεχόμενα</h6>
                            </div>
                            <div class="col-3">
                                <h6>Κόστος</h6>
                            </div>
                        </div>
                    </li>
                    <?php
                    $orders_query = "SELECT id, date, time FROM orders WHERE email='$email'";
                    $orders_result = mysqli_query($con , $orders_query);
                    if (mysqli_num_rows($orders_result) > 0){
                        $row_orders = $orders_result -> fetch_all(MYSQLI_ASSOC);
                        $id = $date = $time = $qty = $coffee = array();
                        foreach ($row_orders as $rowOrders) {
                            $id[] = $rowOrders['id'];
                            $date[] = $rowOrders['date'];
                            $time[] = $rowOrders['time'];
                        }
                        $ids = array_unique($id);
                        foreach($ids as $key => $val){
                            ?>
                            <li class='list-group-item mt-2 mb-4'>
                                <div class='row'>
                                    <div class='col-3'>
                                        <h6><?php echo $ids[$key]; ?></h6>
                                    </div>
                                    <div class='col-3'>
                                        <h6><?php echo $date[$key]; ?></h6>
                                        <p><?php echo $time[$key]; ?></p>
                                    </div>
                                    <div class='col-3'>
                                        <?php
                                        $sqlCPQ = "SELECT coffee, price, qty FROM orders WHERE id = '$ids[$key]'";
                                        $resultCPQ = mysqli_query($con, $sqlCPQ);
                                        $rowCPQ = $resultCPQ -> fetch_all(MYSQLI_ASSOC);
                                        foreach($rowCPQ as $rowCPQ_){
                                            $coffee = $rowCPQ_['coffee'];
                                            $qty = $rowCPQ_['qty'];
                                            echo "<h6>".$qty."x ".$coffee."</h6>";
                                        }
                                        ?>
                                    </div>
                                    <div class='col-3'>
                                        <h6>
                                            <?php
                                            $totalCost = 0;
                                            foreach($rowCPQ as $rowCPQ_){
                                                $price = $rowCPQ_['price'];
                                                $totalCost += $price;
                                            }
                                            $costString = sprintf("%0.2f", $totalCost);
                                            echo $costString;
                                            ?>
                                            €
                                        </h6>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                    }
                    else{?>
                        <li class='list-group-item mt-2 mb-4'>
                            <h6>Δεν υπάρχει καμία παραγγελία.</h6>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
<!-- CARD -->
<?php echo file_get_contents("./html/card.html"); ?>
<!-- SALE SECTION -->
<?php echo file_get_contents("./html/sale.html"); ?>
<!-- Site footer -->
<?php echo file_get_contents("./html/footer.html"); ?>
<script src="./js/cart.js"></script>