<?php
session_start();
$email = $_SESSION['email'];
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
    <link rel="stylesheet" type="text/css" href="./css/order.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="./js/cart.js"></script> -->
    <script>
        $('form').each(function() { this.reset() });
        $(document).ready(function () {
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function () {
                $(this).siblings(".card-header").find(".btn i").html("remove");
            });
            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function () {
                $(this).parent().find(".card-header .btn i").html("remove");
            }).on('hide.bs.collapse', function () {
                $(this).parent().find(".card-header .btn i").html("add");
            });
        });
        /* $(document).ready(function () {
            $('.count').prop('disabled', true);
            $(document).on('click', '.plus', function () {
                $('.count').val(parseInt($('.count').val()) + 1);
            });
            $(document).on('click', '.minus', function () {
                $('.count').val(parseInt($('.count').val()) - 1);
                if ($('.count').val() == 0) {
                    $('.count').val(1);
                }
            });
        }); */
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
        <div class="container space">
            <h1>Διάλεξε τον καφέ που θες</h1>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="accordion" id="accordionExample">
                    <?php
                    include("./php/db_connect.php");
                    $coffees_query = "SELECT * FROM coffees";
                    $result_coffees = mysqli_query($con , $coffees_query);
                    $bootstrap_count = array("One" , "Two" , "Three" , "Four" , "Five" , "Six" , "Seven" , "Eight" , "Nine" , "Ten");
                    $i = 0;
                    while($row = mysqli_fetch_array($result_coffees, MYSQLI_ASSOC)){
                        $code = $row['code'];
                        $name = $row['name'];
                        $price = $row['price'];
                        $milk = $row['milk'];
                        $cinnamon = $row['cinnamon'];
                        $choco = $row['choco'];
                        echo "<div class='card'>
                                <div class='card-header' id='headingOne'>
                                    <h2 class='clearfix mb-0'>
                                        <a class='btn btn-link' data-toggle='collapse' data-target='#collapse".$bootstrap_count[$i]."' aria-expanded='false' aria-controls='collapse".$bootstrap_count[$i]."'>$name ".$price."€<i class='material-icons'>add</i></a>
                                    </h2>
                                </div>
                                <div id='collapse".$bootstrap_count[$i]."' class='collapse' aria-labelledby='heading".$bootstrap_count[$i]."'>
                                    <div class='container space'>
                                        <form action='./php/cart.php' method='POST'>
                                            <div class='row'>
                                                <div class='col-3'>
                                                    <h5>Επίλεξε ζάχαρη</h5>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."1' value='Γλυκός' name='sugar_$code' class='custom-control-input' onclick='uncheck".$i."()' required/>
                                                        <label class='custom-control-label cursor' for='".$code."1'>Γλυκός</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."2' value='Μέτριος' name='sugar_$code' class='custom-control-input' onclick='uncheck".$i."()' required/>
                                                        <label class='custom-control-label cursor' for='".$code."2'>Μέτριος</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."3' value='Σκέτος' name='sugar_$code' class='custom-control-input' onclick='noneSugar".$i."()' required/>
                                                        <label class='custom-control-label cursor' for='".$code."3'>Σκέτος</label>
                                                    </div>
                                                </div>
                                                <div class='col-4'>
                                                    <h5>Επίλεξε είδος ζάχαρης</h5>  
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."4' name='sugarType_$code' value='Λευκή ζάχαρη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='".$code."4'>Λευκή ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."5' name='sugarType_$code' value='Καστανή ζάχαρη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='".$code."5'>Καστανή ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."6' name='sugarType_$code' value='Μαύρη ζάχαρη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='".$code."6'>Μαύρη ζάχαρη</label>
                                                    </div>
                                                    <div class='custom-control custom-radio cursor'>
                                                        <input type='radio' id='".$code."7' name='sugarType_$code' value='Ζαχαρίνη' class='custom-control-input cursor' required>
                                                        <label class='custom-control-label cursor' for='".$code."7'>Ζαχαρίνη</label>
                                                    </div>
                                                </div>
                                                <div class='col-3'>
                                                    <h5>Πρόσθεσε</h5>";
                                                    if($row['milk'] == 1){
                                                        echo "<div class='custom-control custom-checkbox cursor'>
                                                                <input class='custom-control-input cursor' type='checkbox' value='milk' name='milk_$code' id='milk_$code'>
                                                                <label class='custom-control-label cursor' for='milk_$code'>Γάλα</label>
                                                            </div>";
                                                    }
                                                    if($row['cinnamon'] == 1){
                                                        echo "<div class='custom-control custom-checkbox cursor'>
                                                                <input class='custom-control-input cursor' type='checkbox' value='cinnamon' name='cinnamon_$code' id='cinnamon_$code'>
                                                                <label class='custom-control-label cursor' for='cinnamon_$code'>Κανέλα</label>
                                                            </div>";
                                                    }
                                                    if($row['choco'] == 1){
                                                        echo "<div class='custom-control custom-checkbox cursor'>
                                                                <input class='custom-control-input cursor' type='checkbox' value='choco' name='choco_$code' id='choco_$code'>
                                                                <label class='custom-control-label cursor' for='choco_$code'>Σκόνη Σοκολάτας</label>
                                                            </div>";
                                                    }
                                                
                                                echo "
                                            </div> 
                                            </div>
                                            <div class='row space justify-content-center mt-3'>
                                                <button type='submit' name='form$code' class='btn btn-primary btn-md'>Προσθήκη στο καλάθι</button>
                                            </div>
                                        </form>
                                    </div>  
                                </div>
                            </div>";
                            ?>
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
            <div class="col-3">
                <div class="card sticky-top cart">
                    <h4 class="mt-3 mb-3">Το καλάθι σου</h4>
                    <ul class="list-group list-group-flush">
                        <?php
                        $cart_query = "SELECT count, coffee, sugar, sugarType, milk, cinnamon, choco, price FROM cart WHERE email = '$email'";
                        $result_cart = mysqli_query($con, $cart_query);
                        $j = 0;
                        $totalCost = 0;
                        $count = 0;
                        if(mysqli_num_rows($result_cart) >= 1){
                            while($rowCart = mysqli_fetch_array($result_cart, MYSQLI_ASSOC)){
                                $count = $rowCart['count'];
                                $coffee = $rowCart['coffee'];
                                $sugar = $rowCart['sugar'];
                                $sugarType = $rowCart['sugarType'];
                                $milk = $rowCart['milk'];
                                $cinnamon = $rowCart['cinnamon'];
                                $choco = $rowCart['choco'];
                                $price = $rowCart['price'];
                                $totalCost += $price;
                                echo "<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
                                        <h5>$coffee</h5>
                                        <a href='./php/delete_cart.php?count=".$count."' type='button' class='btn btn-sm btn-outline-danger mr-2' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></a>
                                    </li>
                                    <li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 pt-0 mt-0'>
                                        <p class='attr'>".$sugar.", ".$sugarType."";
                                if($milk == 1){
                                    echo ", Γάλα";
                                }
                                if($cinnamon == 1){
                                    echo ", Κανέλα";
                                }
                                if($choco == 1){
                                    echo ", Σκόνη Σοκολάτας";
                                }
                                echo " 
                                        </p>
                                    </li>
                                    <li>
                                        <div class='row d-flex justify-content-center space'>
                                            <div class='col-4 d-flex justify-content-center mt-3'>
                                                <h6>".$price."€</h6>
                                            </div>
                                            <div class='col-8 space'>
                                                <div class='qty d-flex justify-content-center mt-2'>
                                                    <a class='minus bg-dark'>-</a>
                                                    <input type='number' class='count' name='qty' value='1'>
                                                    <a class='plus bg-dark'>+</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>";
                                $j++;
                            }
                        }
                        else{
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
                                    <h6>Το καλάθι σου είναι άδειο</h6>
                                </li>";
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
                    <button type="submit" class="btn btn-primary btn-block btn-lg" <?php if($count == 0) echo "style='cursor: not-allowed' disabled"; ?>>Συνέχεια</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------------- SALE SECTION ---------------------->
    <?php echo file_get_contents("./html/sale.html"); ?>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("./html/footer.html"); ?>
