<?php
session_start();
include_once("./php/db_connect.php");
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
$email = $_SESSION['email'];
$sqlLoggedInUser = "SELECT * FROM cc_users WHERE email = '$email'";
$resultUser = mysqli_query($con, $sqlLoggedInUser);
$rowUser = $resultUser -> fetch_array(MYSQLI_ASSOC);
$firstName = $rowUser['firstName'];
$lastName = $rowUser['lastName'];
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
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script></head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="home.php">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if (isset($_SESSION['email'])) { echo $firstName; } ?></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="profile.php">Ο λογαριασμός μου</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1>Ο λογαριασμός μου</h1>
            </div>
        </div>
    </div>
    <div class="container space py-4">
        <div class="row my-2">
            <div class="col-3 text-center space">
                <div class="sticky-top pt-4 pb-4">
                    <img src="//api.adorable.io/avatars/120/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar" />
                    <h4 class="my-4"><?php echo $firstName; echo ' '; echo $lastName; ?></h4>
                </div>
            </div>
            <div class="col-9 personal-info">
                <form role="form" method="POST" action="./php/changeCreds.php">
                    <h4 class="mb-4">Τα στοιχεία μου</h4>
                    <?php
                    if (isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="form-group row mb-0">
                        <label class="col-5 col-form-label form-control-label pl-3">Όνομα</label>
                        <label class="col-5 col-form-label form-control-label">Επώνυμο</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-5">
                            <input class="form-control" type="text" name="firstName" value="<?php echo $firstName; ?>"/>
                        </div>
                        <div class="col-5">
                            <input class="form-control" type="text" name="lastName" value="<?php echo $lastName; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row mt-4 mb-0">
                        <label class="col-5 col-form-label form-control-label pl-3">email</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-5 mb-0">
                            <input class="form-control" type="text" value="<?php echo $_SESSION['email']; ?>" disabled/>
                        </div>
                    </div>
                    <!-- <div class="form-group row mt-4 mb-0">
                        <label class="col-5 col-form-label form-control-label pl-3">Κινητό</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-5 mb-0">
                            <input class="form-control" type="text" value="phone"/>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <div class="col-12 mt-4 text-left">
                            <input type="submit" name="changeName" class="btn btn-primary btn-lg btn-block" value="Αποθήκευση Αλλαγών"/>
                        </div>
                    </div>
                    <hr class="space">
                </form>
                <form action="./php/changeCreds.php" method="POST">
                    <h4 class="mb-4">Αλλαγή κωδικού</h4>
                    <?php
                    if (isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="form-group row mt-4 mb-0">
                        <label class="col-5 col-form-label form-control-label pl-3">Τρέχων κωδικός</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-5">
                            <input class="form-control" type="password" name="oldpass"/>
                        </div>
                    </div>
                    <div class="form-group row mt-4 mb-0">
                        <label class="col-5 col-form-label form-control-label">Νέος κωδικός</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-5">
                            <input class="form-control" type="password" name="newpass"/>
                        </div>
                    </div>
                    <div class="form-group row mt-5">
                        <div class="col-12 ml-auto text-right">
                            <input type="submit" name="changepass" class="btn btn-primary btn-lg btn-block" value="Αποθήκευση Αλλαγών"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Site footer -->
    <?php echo file_get_contents("./html/footer.html"); ?>
    <script src="./js/cart.js"></script>