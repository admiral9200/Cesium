<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" type="text/css" href="./css/success.css">
    <link rel="icon" type="image/png" href="./images/chip_coffee.png" size="20x20">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="./bootstrap-4.5.0/css/bootstrap.min.css">
    <script src="./bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="index.php">
                <img src="./images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
        </nav>
    </div>
    <div class="container space pt-5 pb-5">
        <div class="alert alert-success" role="alert">
            <div class="text-center">
                <img src="./images/success.png" class="rounded chk" alt="Success">
            </div>
            <h1 class="alert-heading space">Καλωσήρθες στο Chip Coffee!</h1>
            <p class="text-center chk-p">Η εγγραφή σου έγινε με επιτυχία. Θα λάβεις ένα email για την επιβεβαίωση του λογαριασμού σου.</p>
            <a href="index.php">Πίσω στην αρχική</a>
        </div>
    </div>
    <!-------------------- Site footer --------------------------->
    <?php echo file_get_contents("footer.html"); ?>