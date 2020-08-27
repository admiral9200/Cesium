<?php
session_start();
$email = $_SESSION['email'];
include("db_connect.php");
//Minus function. Decrease quantity
if(isset($_GET['qty']) && ($_GET['qty'] == "minus")){
    $counter = $_GET['count'];
    $sql = "SELECT code, price, qty FROM cc_cart WHERE email = '$email' AND count = '$counter' LIMIT 1";
    $resultMinus = mysqli_query($con, $sql);
    $rowMinus = mysqli_fetch_array($resultMinus, MYSQLI_ASSOC);
    $codeCoffee = $rowMinus['code'];
    $sqlCode = "SELECT price FROM cc_coffees WHERE code = '$codeCoffee'";
    $resultGetCode = mysqli_query($con, $sqlCode);
    $rowGetCode = mysqli_fetch_array($resultGetCode, MYSQLI_ASSOC);
    $price = $rowGetCode['price'];
    $quantity = $rowMinus['qty'] - 1;
    $newPrice = $price * $quantity;
    $sqlUpdate = "UPDATE cc_cart SET price = '$newPrice', qty = '$quantity' WHERE email = '$email' AND count = '$counter'";
    mysqli_query($con, $sqlUpdate);
    header("location: ../order.php");
}
//Plus function. Increase quantity
if(isset($_GET['qty']) && ($_GET['qty'] == "plus")){
    $counter = $_GET['count'];
    $sql = "SELECT code, price, qty FROM cc_cart WHERE email = '$email' AND count = '$counter' LIMIT 1";
    $resultPlus = mysqli_query($con, $sql);
    $rowPlus = mysqli_fetch_array($resultPlus, MYSQLI_ASSOC);
    $codeCoffee = $rowPlus['code'];
    $sqlCode = "SELECT price FROM cc_coffees WHERE code = '$codeCoffee'";
    $resultGetCode = mysqli_query($con, $sqlCode);
    $rowGetPrice = mysqli_fetch_array($resultGetCode, MYSQLI_ASSOC);
    $price = $rowGetPrice['price'];
    $quantity = $rowPlus['qty'] + 1;
    $newPrice = $price * $quantity;
    $sqlUpdate = "UPDATE cc_cart SET price = '$newPrice', qty = '$quantity' WHERE email = '$email' AND count = '$counter'";
    mysqli_query($con, $sqlUpdate);
    header("location: ../order.php");
}
//Add to cart coffees
if(isset($_POST['addToCart'])){
    $names_query = "SELECT code,name,price FROM cc_coffees";
    $result_names = mysqli_query($con , $names_query);
    $coffees = $result_names -> fetch_all(MYSQLI_ASSOC);
    $i = 0;
    $milkCheck = 0;
    $cinnamonCheck = 0;
    $chocoCheck = 0;
    //set adds variables in coffees
    foreach($coffees as $rowCheck) {
        $codeCheckDup = $rowCheck['code'];
        $formCheckDup = "form".$codeCheckDup;
        $milkCheckDup = "milk_".$rowCheck['code'];
        $cinnamonCheckDup = "cinnamon_".$rowCheck['code'];
        $chocoCheckDup = "choco_".$rowCheck['code'];
        if($formCheckDup == $_POST['addToCart']){
            if(isset($_POST[$milkCheckDup])){
                $milkCheck = 1;
            }
            if(isset($_POST[$cinnamonCheckDup])){
                $cinnamonCheck = 1;
            }
            if(isset($_POST[$chocoCheckDup])){
                $chocoCheck = 1;
            }
            $priceOne = $rowCheck['price'];
            $nameCheckDup = $rowCheck['name'];
            $sugarCheckDup = "sugar_".$rowCheck['code'];
            $sugarTypeCheckDup = "sugarType_".$rowCheck['code'];
            break;
        }
    }
    //checking duplicates coffees exactly
    $checkDupQuery = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco, qty FROM cc_cart WHERE email = '$email' AND coffee = '$nameCheckDup' AND sugar = '$_POST[$sugarCheckDup]' AND sugarType = '$_POST[$sugarTypeCheckDup]' AND milk = '$milkCheck' AND cinnamon = '$cinnamonCheck' AND choco = '$chocoCheck'";    $resultCheckDup = mysqli_query($con, $checkDupQuery);
    if(mysqli_num_rows($resultCheckDup) == 1){
        $rowOne = mysqli_fetch_array($resultCheckDup, MYSQLI_ASSOC);
        $quantity = $rowOne['qty'] + 1;
        $newPrice = $priceOne * $quantity;
        $updateQuantity = "UPDATE cc_cart SET price = '$newPrice',qty = '$quantity' WHERE email = '$email' AND coffee = '$nameCheckDup' AND sugar = '$_POST[$sugarCheckDup]' AND sugarType = '$_POST[$sugarTypeCheckDup]' AND milk = '$milkCheck' AND cinnamon = '$cinnamonCheck' AND choco = '$chocoCheck'";
        mysqli_query($con, $updateQuantity);
    }
    else{
        //INSERT TO CART COFFEESSS :D
        $cart_query = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco FROM cc_cart WHERE email = '$email'";
        $result_cart = mysqli_query($con, $cart_query);
        $count = mysqli_num_rows($result_cart);
        foreach($coffees as $row){
            $code = $row['code'];
            $form = "form".$code;
            $name = $row['name'];
            $price = $row['price'];
            $sugar = "sugar_".$row['code'];
            $sugarType = "sugarType_".$row['code'];
            $milk = "milk_".$row['code'];
            $cinnamon = "cinnamon_".$row['code'];
            $choco = "choco_".$row['code'];
            if (isset($_POST[$sugar])){
                $count++;
                $cart_query = "INSERT INTO cc_cart (email, count, code, coffee, sugar, sugarType, price, qty) VALUES('$email', '$count', '$code', '$name', '$_POST[$sugar]', '$_POST[$sugarType]', '$price', 1)";
                mysqli_query($con, $cart_query);
                if(isset($_POST[$milk])){
                    $milkAdded = 1;
                    $milkAdded_query = "UPDATE cc_cart SET milk = '$milkAdded' WHERE email = '$email' AND count = '$count' AND sugar = '$_POST[$sugar]' AND sugarType = '$_POST[$sugarType]'";
                    mysqli_query($con, $milkAdded_query) or trigger_error("Query Failed! SQL: $milkAdded_query - Error: ".mysqli_error($con), E_USER_ERROR);
                }
                if(isset($_POST[$cinnamon])){
                    $cinnamonAdded = 1;
                    $cinnamonAdded_query = "UPDATE cc_cart SET cinnamon= '$cinnamonAdded' WHERE email = '$email' AND count = '$count' AND sugar = '$_POST[$sugar]' AND sugarType = '$_POST[$sugarType]'";
                    mysqli_query($con, $cinnamonAdded_query) or trigger_error("Query Failed! SQL: $milkAdded_query - Error: ".mysqli_error($con), E_USER_ERROR);
                }
                if(isset($_POST[$choco])){
                    $cinnamonAdded = 1;
                    $chocoAdded_query = "UPDATE cc_cart SET choco = '$cinnamonAdded' WHERE email = '$email' AND count = '$count' AND sugar = '$_POST[$sugar]' AND sugarType = '$_POST[$sugarType]'";
                    mysqli_query($con, $chocoAdded_query) or trigger_error("Query Failed! SQL: $milkAdded_query - Error: ".mysqli_error($con), E_USER_ERROR);
                }
                break;
            }
            $i++;
        }
    }
    header("location: ../order.php");
}