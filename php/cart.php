<?php
session_start();
$email = $_SESSION['email'];
include("db_connect.php");
$names_query = "SELECT code,name,price FROM coffees";
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
    if(isset($_POST[$formCheckDup])){
        if(isset($_POST[$milkCheckDup])){
            $milkCheck = 1;
        }
        if(isset($_POST[$cinnamonCheckDup])){
            $cinnamonCheck = 1;
        }
        if(isset($_POST[$chocoCheckDup])){
            $chocoCheck = 1;
        }
        break;
        $nameCheckDup = $row['name'];
        $priceCheckDup = $row['price'];
    }
}
//checking duplicates coffees exactly (not yet)

$cart_query = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco FROM cart WHERE email = '$email'";
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
    if (isset($_POST[$form]) && isset($_POST[$sugar])){
        $count++;
        $cart_query = "INSERT INTO cart (email, code, count, coffee, sugar, sugarType, price) VALUES('$email', '$code', '$count', '$name', '$_POST[$sugar]', '$_POST[$sugarType]', '$price')";
        mysqli_query($con, $cart_query);
        if(isset($_POST[$milk])){
            $milkAdded = 1;
            $milkAdded_query = "UPDATE cart SET milk = '$milkAdded' WHERE email = '$email' AND code = '$code' AND count = '$count' AND sugar = '$_POST[$sugar]' AND sugarType = '$_POST[$sugarType]'";
            mysqli_query($con, $milkAdded_query) or trigger_error("Query Failed! SQL: $milkAdded_query - Error: ".mysqli_error($con), E_USER_ERROR);
        }
        if(isset($_POST[$cinnamon])){
            $cinnamonAdded = 1;
            $cinnamonAdded_query = "UPDATE cart SET cinnamon= '$cinnamonAdded' WHERE email = '$email' AND code = '$code'  AND count = '$count' AND sugar = '$_POST[$sugar]' AND sugarType = '$_POST[$sugarType]'";
            mysqli_query($con, $cinnamonAdded_query) or trigger_error("Query Failed! SQL: $milkAdded_query - Error: ".mysqli_error($con), E_USER_ERROR);
        }
        if(isset($_POST[$choco])){
            $cinnamonAdded = 1;
            $chocoAdded_query = "UPDATE cart SET choco = '$cinnamonAdded' WHERE email = '$email' AND code = '$code' AND count = '$count' AND sugar = '$_POST[$sugar]' AND sugarType = '$_POST[$sugarType]'";
            mysqli_query($con, $chocoAdded_query) or trigger_error("Query Failed! SQL: $milkAdded_query - Error: ".mysqli_error($con), E_USER_ERROR);
        }
        break;
    }
    $i++;
}
header("location: ../order.php");