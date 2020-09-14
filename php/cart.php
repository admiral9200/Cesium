<?php
session_start();
$email = $_SESSION['email'];
include("db_connect.php");
//Minus function. Decrease quantity
if(isset($_GET['qty']) && ($_GET['qty'] === "minus")){
    $counter = $_GET['counter'];
    $sqlMinus = "SELECT code, price, qty FROM cc_cart WHERE email = ? AND count = ? LIMIT 1";
    $stmtMinus = $pdo -> prepare($sqlMinus);
    $stmtMinus -> execute([$email, $counter]);
    $rowMinus = $stmtMinus -> fetch();
    $codeCoffee = $rowMinus['code'];
    $sqlCode = "SELECT price FROM cc_coffees WHERE code = ?";
    $stmtGetPrice = $pdo -> prepare($sqlCode);
    $stmtGetPrice -> execute([$codeCoffee]);
    $rowGetPrice = $stmtGetPrice -> fetch();
    $price = $rowGetPrice['price'];
    $quantity = $rowMinus['qty'] - 1;
    $newPrice = $price * $quantity;
    $sqlUpdate = "UPDATE cc_cart SET price = ?, qty = ? WHERE email = ? AND count = ?";
    $stmtUpdate = $pdo -> prepare($sqlUpdate);
    $stmtUpdate -> execute([$newPrice, $quantity, $email, $counter]);
    header("location: ../order/");
}
//Plus function. Increase quantity
if(isset($_GET['qty']) && ($_GET['qty'] === "plus")){
    $counter = $_GET['counter'];
    $sqlPlus = "SELECT code, price, qty FROM cc_cart WHERE email = ? AND count = ? LIMIT 1";
    $stmtPlus = $pdo -> prepare($sqlPlus);
    $stmtPlus -> execute([$email, $counter]);
    $rowPlus = $stmtPlus -> fetch();
    $codeCoffee = $rowPlus['code'];
    $sqlCode = "SELECT price FROM cc_coffees WHERE code = ?";
    $stmtGetPrice = $pdo -> prepare($sqlCode);
    $stmtGetPrice -> execute([$codeCoffee]);
    $rowGetPrice = $stmtGetPrice -> fetch();
    $price = $rowGetPrice['price'];
    $quantity = $rowPlus['qty'] + 1;
    $newPrice = $price * $quantity;
    $sqlUpdate = "UPDATE cc_cart SET price = ?, qty = ? WHERE email = ? AND count = ?";
    $stmtUpdate = $pdo -> prepare($sqlUpdate);
    $stmtUpdate -> execute([$newPrice, $quantity, $email, $counter]);
    header("location: ../order/");
}
//Cart
if(isset($_POST['addToCart'])){
    $stmtNames = $pdo -> query("SELECT code,name,price FROM cc_coffees");
    $coffees = $stmtNames -> fetchAll();
    $i = 0;
    $milkCheck = 0;
    $cinnamonCheck = 0;
    $chocoCheck = 0;
    //set adds variables in coffees
    foreach($coffees as $rowCheck){
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
    $checkDupQuery = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco, qty FROM cc_cart WHERE email = ? AND coffee = ? AND sugar = ? AND sugarType = ? AND milk = ? AND cinnamon = ? AND choco = ?";
    $stmtCheckDup = $pdo -> prepare($checkDupQuery);
    $stmtCheckDup -> execute([$email, $nameCheckDup, $_POST[$sugarCheckDup], $_POST[$sugarTypeCheckDup], $milkCheck, $cinnamonCheck, $chocoCheck]);
    if($stmtCheckDup -> rowCount() == 1){
        $rowOne = $stmtCheckDup -> fetch();
        $quantity = $rowOne['qty'] + 1;
        $newPrice = $priceOne * $quantity;
        $updateQuantity = "UPDATE cc_cart SET price = ? , qty = ? WHERE email = ? AND coffee = ? AND sugar = ? AND sugarType = ? AND milk = ? AND cinnamon = ? AND choco = ?";
        $stmtUpdateQty = $pdo -> prepare($updateQuantity);
        $stmtUpdateQty -> execute([$newPrice, $quantity, $email, $nameCheckDup, $_POST[$sugarCheckDup], $_POST[$sugarTypeCheckDup], $milkCheck, $cinnamonCheck, $chocoCheck]);
    }
    else{
        //For counting coffees in cart
        $cart_query = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco FROM cc_cart WHERE email = ?";
        $stmtCart = $pdo -> prepare($cart_query);
        $stmtCart -> execute([$email]);
        $count = $stmtCart -> rowCount();
        //INSERT TO CART COFFEESSS :D
        foreach($coffees as $row){
            $name = $row['name'];
            $price = $row['price'];
            $code = $row['code'];
            $form = "form".$code;
            $sugar = "sugar_".$row['code'];
            $sugarType = "sugarType_".$row['code'];
            $milk = "milk_".$row['code'];
            $cinnamon = "cinnamon_".$row['code'];
            $choco = "choco_".$row['code'];
            if(!isset($_POST[$sugarType])) $_POST[$sugarType] = "";
            if (isset($_POST[$sugar])){
                $count++;
                $cart_query = "INSERT INTO cc_cart (email, count, code, coffee, sugar, sugarType, price, qty) VALUES( ? , ? , ? , ? , ? , ? , ? , 1)";
                $stmtCartInsert = $pdo -> prepare($cart_query);
                $stmtCartInsert -> execute([$email, $count, $code, $name, $_POST[$sugar], $_POST[$sugarType], $price]);
                if(isset($_POST[$milk])){
                    $milkAdded = 1;
                    $milkAdded_query = "UPDATE cc_cart SET milk = ? WHERE email = ? AND count = ? AND sugar = ? AND sugarType = ?";
                    $stmtMilkAdd = $pdo -> prepare($milkAdded_query);
                    $stmtMilkAdd -> execute([$milkAdded, $email, $count, $_POST[$sugar], $_POST[$sugarType]]);
                }
                if(isset($_POST[$cinnamon])){
                    $cinnamonAdded = 1;
                    $cinnamonAdded_query = "UPDATE cc_cart SET cinnamon= ? WHERE email = ? AND count = ? AND sugar = ? AND sugarType = ?";
                    $stmtCinnamonAdd = $pdo -> prepare($cinnamonAdded_query);
                    $stmtCinnamonAdd -> execute([$cinnamonAdded, $email, $count, $_POST[$sugar], $_POST[$sugarType]]);
                }
                if(isset($_POST[$choco])){
                    $chocoAdded = 1;
                    $chocoAdded_query = "UPDATE cc_cart SET choco = ? WHERE email = ? AND count = ? AND sugar = ? AND sugarType = ?";
                    $stmtChocoAdd = $pdo -> prepare($chocoAdded_query);
                    $stmtChocoAdd -> execute([$chocoAdded, $email, $count, $_POST[$sugar], $_POST[$sugarType]]);
                }
                break;
            }
            $i++;
        }
    }
    header("location: ../order/");
}
//Delete one coffee from cart
if(isset($_GET['count']) && is_numeric($_GET['count'])){
    $countToDelete = $_GET['count'];
    $deleteQuery = "DELETE FROM cc_cart WHERE email = ? AND count = ?";
    $stmtDeleteCoffee = $pdo -> prepare($deleteQuery);
    $stmtDeleteCoffee -> execute([$email, $countToDelete]);
    header("location: ../order/");
}
?>