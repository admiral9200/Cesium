<?php
session_start();
include("../php/db_connect.php");
$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
$sqlLoggedInUser = "SELECT * FROM cc_users WHERE email = ?";
$resultUser = $pdo -> prepare($sqlLoggedInUser);
$resultUser -> execute([$email]);
$user = $resultUser -> fetch();
$firstName = $user['firstName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="../css/order.css">
    <link rel="icon" type="image/png" href="../images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css"> 
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="../home/">
                <img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName; ?> <i class="far fa-user"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="../profile.php">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="container space">
            <h1>Διάλεξε τον καφέ που θες</h1>
        </div>
    </div>
    <div class="container">
        <div id="false" class="mt-3"></div>
        <div class="row">
            <div class="col-12 col-xl-9 order-1 order-xl-0 coffees">
                <div class="accordion" id="accordionExample">
                    <?php
                    $result_coffees = $pdo -> query('SELECT * FROM cc_coffees');
                    $bootstrap_count = array("One" , "Two" , "Three" , "Four" , "Five" , "Six" , "Seven" , "Eight" , "Nine" , "Ten");
                    $i = 0;
                    while($row = $result_coffees -> fetch()){
                        $code = $row['code'];
                        $name = $row['name'];
                        $price = $row['price'];
                        $milk = $row['milk'];
                        $cinnamon = $row['cinnamon'];
                        $choco = $row['choco'];
                        ?><div class='card'>
                                <div class='card-header p-0 align-middle' id='headingOne'>
                                    <a class='btn btn-link p-3' data-toggle='collapse' data-target='#collapse<?php echo $bootstrap_count[$i]; ?>' aria-expanded='false' aria-controls='collapse<?php echo $bootstrap_count[$i];?>'><?php echo $name." ".$price;?>€<i class="fas fa-plus float-right mt-1"></i></a>
                                </div>
                                <div id='collapse<?php echo $bootstrap_count[$i];?>' class='collapse' aria-labelledby='heading<?php echo $bootstrap_count[$i];?>'>
                                    <div class='container space'>
                                        <form class="w-100">
                                            <div class='row'>
                                                <div class='col-xl-3 col-12 mb-2'>
                                                    <h5>Επίλεξε ζάχαρη</h5>
                                                    <div class='custom-control custom-radio cursor' onclick='uncheck(<?php echo $code;?>)'>
                                                        <input type='radio' id='s<?php echo $code;?>' value='Γλυκός' name='sugar<?php echo $code;?>' class='custom-control-input' data-toggle="popover"/>
                                                        <label class='custom-control-label cursor' for='s<?php echo $code;?>'>Γλυκός</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor' onclick='uncheck(<?php echo $code;?>)'>
                                                        <input type='radio' id='m<?php echo $code;?>' value='Μέτριος' name='sugar<?php echo $code;?>' class='custom-control-input'/>
                                                        <label class='custom-control-label cursor' for='m<?php echo $code;?>'>Μέτριος</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor' onclick='noneSugar(<?php echo $code;?>)'>
                                                        <input type='radio' id='no<?php echo $code;?>' value='Σκέτος' name='sugar<?php echo $code;?>' class='custom-control-input'/>
                                                        <label class='custom-control-label cursor' for='no<?php echo $code;?>'>Σκέτος</label>
                                                    </div>
                                                </div>
                                                <div class='col-xl-4 col-12 mb-2'>
                                                    <h5>Επίλεξε είδος ζάχαρης</h5>  
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='WH<?php echo $code;?>' name='sugarType<?php echo $code;?>' value='Λευκή ζάχαρη' class='custom-control-input cursor' data-toggle="popover">
                                                        <label class='custom-control-label cursor' for='WH<?php echo $code;?>'>Λευκή ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='BR<?php echo $code;?>' name='sugarType<?php echo $code;?>' value='Καστανή ζάχαρη' class='custom-control-input cursor'>
                                                        <label class='custom-control-label cursor' for='BR<?php echo $code;?>'>Καστανή ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='BL<?php echo $code;?>' name='sugarType<?php echo $code;?>' value='Μαύρη ζάχαρη' class='custom-control-input cursor'>
                                                        <label class='custom-control-label cursor' for='BL<?php echo $code;?>'>Μαύρη ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='SA<?php echo $code;?>' name='sugarType<?php echo $code;?>' value='Ζαχαρίνη' class='custom-control-input cursor'>
                                                        <label class='custom-control-label cursor' for='SA<?php echo $code;?>'>Ζαχαρίνη</label>
                                                    </div>
                                                </div>
                                                <div class='col-xl-3 col-12 mb-2'>
                                                    <h5>Πρόσθεσε</h5>
                                                    <?php
                                                    if($row['milk'] == 1){
                                                        ?>
                                                        <div class='custom-control custom-checkbox cursor'>
                                                            <input class='custom-control-input cursor' type='checkbox' name='milk<?php echo $code;?>' id='milk_<?php echo $code;?>'>
                                                            <label class='custom-control-label cursor' for='milk_<?php echo $code;?>'>Γάλα</label>
                                                        </div>
                                                        <?php
                                                    }
                                                    if($row['cinnamon'] == 1){
                                                        ?>
                                                        <div class='custom-control custom-checkbox cursor'>
                                                            <input class='custom-control-input cursor' type='checkbox' name='cinnamon<?php echo $code;?>' id='cinnamon_<?php echo $code;?>'>
                                                            <label class='custom-control-label cursor' for='cinnamon_<?php echo $code;?>'>Κανέλα</label>
                                                        </div>
                                                        <?php
                                                    }
                                                    if($row['choco'] == 1){
                                                        ?>
                                                        <div class='custom-control custom-checkbox cursor'>
                                                            <input class='custom-control-input cursor' type='checkbox' name='choco<?php echo $code;?>' id='choco_<?php echo $code;?>'>
                                                            <label class='custom-control-label cursor' for='choco_<?php echo $code;?>'>Σκόνη Σοκολάτας</label>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div> 
                                            </div>
                                        </form>
                                        <div class='row space justify-content-center mt-3'>
                                            <button type='button' class='btn btn-primary btn-md' onclick="getValues(<?php echo $code;?>)">Προσθήκη στο καλάθι</button>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <div class="col-xl-3 col-12 order-0 order-xl-1">
                <div class="card sticky-top cart" id="cart"></div>
            </div>
        </div>
    </div>
    <!--------------------- SALE SECTION ---------------------->
    <?php echo file_get_contents("../html/sale.html"); ?>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("../html/footer.html"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="order.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
</body>
</html>