<?php
session_start();
include("./php/db_connect.php");
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
    <link rel="stylesheet" type="text/css" href="./css/order.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css"> 
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="home.php">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName; ?> <i class="far fa-user"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="profile.php">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="container space">
            <h1>Διάλεξε τον καφέ που θες</h1>
        </div>
    </div>
    <div class="container">
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
                                <div class='card-header' id='headingOne'>
                                    <h2 class='clearfix p-0'>
                                        <a class='btn btn-link p-0' data-toggle='collapse' data-target='#collapse<?php echo $bootstrap_count[$i]; ?>' aria-expanded='false' aria-controls='collapse<?php echo $bootstrap_count[$i];?>'><?php echo $name." ".$price;?>€<i class="fas fa-plus float-right"></i></a>
                                    </h2>
                                </div>
                                <div id='collapse<?php echo $bootstrap_count[$i];?>' class='collapse' aria-labelledby='heading<?php echo $bootstrap_count[$i];?>'>
                                    <div class='container space'>
                                        <form action='./php/cart.php' method='POST'>
                                            <div class='row'>
                                                <div class='col-xl-3 col-12 mb-2'>
                                                    <h5>Επίλεξε ζάχαρη</h5>
                                                    <div class='custom-control custom-radio cursor' onclick='uncheck<?php echo $i;?>()'>
                                                        <input type='radio' id='<?php echo $code;?>1' value='Γλυκός' name='sugar_<?php echo $code;?>' class='custom-control-input' required/>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>1'>Γλυκός</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor' onclick='uncheck<?php echo $i;?>()'>
                                                        <input type='radio' id='<?php echo $code;?>2' value='Μέτριος' name='sugar_<?php echo $code;?>' class='custom-control-input' required/>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>2'>Μέτριος</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor' onclick='noneSugar<?php echo $i;?>()'>
                                                        <input type='radio' id='<?php echo $code;?>3' value='Σκέτος' name='sugar_<?php echo $code;?>' class='custom-control-input' required/>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>3'>Σκέτος</label>
                                                    </div>
                                                </div>
                                                <div class='col-xl-4 col-12 mb-2'>
                                                    <h5>Επίλεξε είδος ζάχαρης</h5>  
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='<?php echo $code;?>4' name='sugarType_<?php echo $code;?>' value='Λευκή ζάχαρη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>4'>Λευκή ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='<?php echo $code;?>5' name='sugarType_<?php echo $code;?>' value='Καστανή ζάχαρη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>5'>Καστανή ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='<?php echo $code;?>6' name='sugarType_<?php echo $code;?>' value='Μαύρη ζάχαρη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>6'>Μαύρη ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='<?php echo $code;?>7' name='sugarType_<?php echo $code;?>' value='Ζαχαρίνη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='<?php echo $code;?>7'>Ζαχαρίνη</label>
                                                    </div>
                                                </div>
                                                <div class='col-xl-3 col-12 mb-2'>
                                                    <h5>Πρόσθεσε</h5>
                                                    <?php
                                                    if($row['milk'] == 1){
                                                        ?>
                                                        <div class='custom-control custom-checkbox cursor'>
                                                            <input class='custom-control-input cursor' type='checkbox' value='milk' name='milk_<?php echo $code;?>' id='milk_<?php echo $code;?>'>
                                                            <label class='custom-control-label cursor' for='milk_<?php echo $code;?>'>Γάλα</label>
                                                        </div>
                                                        <?php
                                                    }
                                                    if($row['cinnamon'] == 1){
                                                        ?>
                                                        <div class='custom-control custom-checkbox cursor'>
                                                            <input class='custom-control-input cursor' type='checkbox' value='cinnamon' name='cinnamon_<?php echo $code;?>' id='cinnamon_<?php echo $code;?>'>
                                                            <label class='custom-control-label cursor' for='cinnamon_<?php echo $code;?>'>Κανέλα</label>
                                                        </div>
                                                        <?php
                                                    }
                                                    if($row['choco'] == 1){
                                                        ?>
                                                        <div class='custom-control custom-checkbox cursor'>
                                                            <input class='custom-control-input cursor' type='checkbox' value='choco' name='choco_<?php echo $code;?>' id='choco_<?php echo $code;?>'>
                                                            <label class='custom-control-label cursor' for='choco_<?php echo $code;?>'>Σκόνη Σοκολάτας</label>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div> 
                                            </div>
                                            <div class='row space justify-content-center mt-3'>
                                                <button type='submit' name='addToCart' value='form<?php echo $code;?>' class='btn btn-primary btn-md'>Προσθήκη στο καλάθι</button>
                                            </div>
                                        </form>
                                    </div>  
                                </div>
                            </div>
                            <script type="text/javascript">
                                function noneSugar<?php echo $i; ?>(){
                                    document.getElementById("<?php echo $code.'3'; ?>").onclick = function(){
                                        var sugarTypes = document.getElementsByName("<?php echo "sugarType_$code"; ?>");
                                        for (let index = 0; index < sugarTypes.length; index++) {
                                            sugarTypes[index].disabled = true;
                                            sugarTypes[index].checked = false;
                                        }
                                    }
                                }
                                function uncheck<?php echo $i; ?>(){
                                    document.getElementById("<?php echo $code.'1'; ?>").onclick = function(){
                                        var sugarTypes = document.getElementsByName("<?php echo "sugarType_$code"; ?>");
                                        for (let index = 0; index < sugarTypes.length; index++) {
                                            sugarTypes[index].disabled = false;
                                        }
                                    }
                                    document.getElementById("<?php echo $code.'2'; ?>").onclick = function(){
                                        var sugarTypes = document.getElementsByName("<?php echo "sugarType_$code"; ?>");
                                        for (let index = 0; index < sugarTypes.length; index++) {
                                            sugarTypes[index].disabled = false;
                                        }
                                    }
                                }
                            </script>
                            <?php
                        $i += 1;
                    }
                    ?>
                </div>
            </div>
            <div class="col-xl-3 col-12 order-0 order-xl-1">
                <div class="card sticky-top cart">
                    <h4 class="mt-3 mb-3">Το καλάθι σου</h4>
                    <ul class="list-group list-group-flush">
                        <?php
                        $cart_query = "SELECT count, coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cc_cart WHERE email = ?";
                        $stmtCart = $pdo -> prepare($cart_query);
                        $stmtCart -> execute([$email]);
                        $totalCost = 0;
                        $count = 0;
                        if($stmtCart -> rowCount() >= 1){
                            while($rowCart = $stmtCart -> fetch()){
                                $count = $rowCart['count'];
                                $coffee = $rowCart['coffee'];
                                $sugar = $rowCart['sugar'];
                                $sugarType = $rowCart['sugarType'];
                                $milk = $rowCart['milk'];
                                $cinnamon = $rowCart['cinnamon'];
                                $choco = $rowCart['choco'];
                                $price = $rowCart['price'];
                                $quantity = $rowCart['qty'];
                                $totalCost += $price;
                                ?>
                                <li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
                                    <h5><?php echo $coffee; ?></h5>
                                    <a href='./php/delete_cart.php?count=<?php echo $count; ?>' type='button' class='btn btn-sm btn-outline-danger mr-2' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></a>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 pt-0 mt-0'>
                                    <p class='attr'>
                                        <?php 
                                        echo $sugar;
                                        if(!empty($sugarType)) echo ", ".$sugarType;
                                        if($milk == 1) echo ", Γάλα";
                                        if($cinnamon == 1) echo ", Κανέλα";
                                        if($choco == 1) echo ", Σκόνη Σοκολάτας";
                                        ?> 
                                    </p>
                                </li>
                                <li>
                                    <div class='row d-flex justify-content-center space'>
                                        <div class='col-4 d-flex justify-content-center mt-3'>
                                            <h6><?php echo $price; ?>€</h6>
                                        </div>
                                        <div class='col-8 space'>
                                            <div class='qty d-flex justify-content-center mt-2'>
                                                <a class='minus' <?php if($quantity > 1) echo "href='./php/cart.php?qty=minus&&count=$count'"; ?> id="minus">-</a>
                                                <input type='number' class='count' name='qty' value="<?php echo $quantity; ?>" disabled>
                                                <a class='plus' href="./php/cart.php?qty=plus&&count=<?php echo $count; ?>" id="plus">+</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
                                <h6>Το καλάθι σου είναι άδειο</h6>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 mt-5">
                            <div>
                                <strong>Συνολικό Κόστος</strong>
                            </div>
                            <span><strong>
                                <?php
                                $costString = sprintf("%0.2f", $totalCost);
                                echo $costString;
                                ?>
                                €</strong></span>
                        </li>
                    </ul>
                    <form action="checkout.php" method="POST">
                        <button type="submit" name="continue" class="btn btn-primary btn-block btn-lg" <?php if($count == 0) echo "style='cursor: not-allowed' disabled"; ?>>Συνέχεια</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--------------------- SALE SECTION ---------------------->
    <?php echo file_get_contents("./html/sale.html"); ?>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("./html/footer.html"); ?>
    <script src="./js/order.js"></script>