<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="icon" type="image/png" href="../images/chip_coffee.png">
    <link rel="stylesheet" href="../bootstrap-4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div id="viewProfile"></div>
    <!-- Site footer -->
    <?php echo file_get_contents("../html/footer.html"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script>
        $("#viewProfile").load("view_profile.php");
    </script>
</body>
</html>