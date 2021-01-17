<?php
session_start();
if (!isset($_SESSION['email'])) header('location: /');
$email = $_SESSION['email'];
include("../php/db_connect.php");

$fetchCoffees = $pdo -> query('SELECT * FROM cc_coffees');
echo json_encode($fetchCoffees -> fetchAll());