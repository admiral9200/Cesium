<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "chip_coffee";
$dsn = 'mysql:host='. $host. ';dbname=' .$dbname;
$pdo = new PDO($dsn, $username, $password);
$pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
?>