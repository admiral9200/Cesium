<?php
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
    <link rel="stylesheet" type="text/css" href="./css/order.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png" size="20x20">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script>
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
        $(document).ready(function () {
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
        });
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
                  <a class="dropdown-item" href="home.php">Οι παραγγελίες μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="container space">
            <h1>Διάλεξε τον καφέ που θες</h1>
        </div>
    </div>
    <!---------------------COFFEE ORDER MENU---------------------->
    <div class="container">
        <form action="checkout.php" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="clearfix mb-0">
                                    <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Espresso 0,50€<i class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                <div class="container space">
                                    <div class="row">
                                        <div class="col-3">
                                            <h5>Επίλεξε ζάχαρη</h5>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio1" name="sugar" class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio1">Γλυκός</label>
                                            </div>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio2" name="sugar" class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio2">Μέτριος</label>
                                            </div>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio3" name="sugar" class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio3">Σκέτος</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <h5>Επίλεξε είδος ζάχαρης</h5>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio4" name="sugarType" class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio4">Λευκή ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio5" name="sugarType" class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio5">Καστανή ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio6" name="sugarType"class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio6">Μαύρη ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio cursor">
                                                <input type="radio" id="customRadio7" name="sugarType" class="custom-control-input cursor">
                                                <label class="custom-control-label cursor" for="customRadio7">Ζαχαρίνη</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <h5>Πρόσθεσε</h5>
                                            <div class="custom-control custom-checkbox cursor">
                                                <input class="custom-control-input cursor" type="checkbox" value="" id="milk">
                                                <label class="custom-control-label cursor" for="milk">Γάλα</label>
                                            </div>
                                            <div class="custom-control custom-checkbox cursor">
                                                <input class="custom-control-input cursor" type="checkbox" value="" id="cinnamon">
                                                <label class="custom-control-label cursor" for="cinnamon">Κανέλα</label>
                                            </div>
                                            <div class="custom-control custom-checkbox cursor">
                                                <input class="custom-control-input cursor" type="checkbox" value="" id="choco">
                                                <label class="custom-control-label cursor" for="choco">Σκόνη Σοκολάτας</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row space justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary btn-md">Προσθήκη στο καλάθι</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">Cappuccino 0,70€<i
                                            class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
                                <div class="container space">
                                    <div class="row">
                                        <div class="col-3">
                                            <h5>Επίλεξε ζάχαρη</h5>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="sugar"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">Γλυκός</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="sugar"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio2">Μέτριος</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio3" name="sugar"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio3">Σκέτος</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <h5>Επίλεξε είδος ζάχαρης</h5>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio4" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio4">Λευκή
                                                    ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio5" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio5">Καστανή
                                                    ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio6" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio6">Μαύρη
                                                    ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio7" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio7">Ζαχαρίνη</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <h5>Πρόσθεσε</h5>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="milk">
                                                <label class="form-check-label" for="milk">Γάλα</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cinnamon">
                                                <label class="form-check-label" for="cinnamon">Κανέλα</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="choco">
                                                <label class="form-check-label" for="choco">Σκόνη Σοκολάτας</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <a class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">Cappuccino latte 1,00€<i
                                            class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree">
                                <div class="container space">
                                    <div class="row">
                                        <div class="col-3">
                                            <h5>Επίλεξε ζάχαρη</h5>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="sugar"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">Γλυκός</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="sugar"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio2">Μέτριος</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio3" name="sugar"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio3">Σκέτος</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <h5>Επίλεξε είδος ζάχαρης</h5>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio4" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio4">Λευκή
                                                    ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio5" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio5">Καστανή
                                                    ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio6" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio6">Μαύρη
                                                    ζάχαρη</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio7" name="sugarType"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio7">Ζαχαρίνη</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <h5>Πρόσθεσε</h5>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="milk">
                                                <label class="form-check-label" for="milk">Γάλα</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cinnamon">
                                                <label class="form-check-label" for="cinnamon">Κανέλα</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="choco">
                                                <label class="form-check-label" for="choco">Σκόνη Σοκολάτας</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">Freddo Espresso 0,70€<i
                                            class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour">
                                <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                    accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                    skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                    moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                    shoreditch et.</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">Freddo Cappuccino 0,80€<i
                                            class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive">
                                <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                    accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                    skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                    moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                    shoreditch et.</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <h2 class="mb-0">
                                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix"
                                        aria-expanded="false" aria-controls="collapseSix">Freddo Cappuccino Latte
                                        0,80€<i class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix">
                                <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                    accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                    skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                    moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                    shoreditch et.</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                                <h2 class="mb-0">
                                    <a class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">Frappe 0,30€<i class="material-icons">add</i></a>
                                </h2>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven">
                                <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                    accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                    skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                    moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                    shoreditch et.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!------------------------------------- CHECKOUT ---------------------------------------->
                <div class="col-3">
                    <div class="card sticky-top mb-3">
                        <div class="pt-4">
                            <h4>Το καλάθι σου</h4>
                            <!--DYNAMIC PRODUCTS GO BELOW-->
                            <ul class="list-group list-group-flush">
                                <div id="product">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                        Cappuccino
                                        <button type="button" class="btn btn-sm btn-outline-danger mr-2" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </li>
                                    <li>
                                        <div class="row d-flex justify-content-center space">
                                            <div class="col-4 d-flex justify-content-center mt-3">
                                                <h6>0,70€</h6>
                                            </div>
                                            <div class="col-8 space">
                                                <div class="qty d-flex justify-content-center mt-2">
                                                    <span class="minus bg-dark">-</span>
                                                    <input type="number" class="count" name="qty" value="1">
                                                    <span class="plus bg-dark">+</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Συνολικό Κόστος</strong>
                                    </div>
                                    <span><strong>0,00€</strong></span>
                                </li>
                            </ul>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Συνέχεια</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--------------------- SALE SECTION ---------------------->
    <?php echo file_get_contents("sale.html"); ?>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("footer.html"); ?>