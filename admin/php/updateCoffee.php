<?php
session_start();
if (!isset($_SESSION['admin'])) {
	session_destroy();
	header('location: ../');
}
include_once("db.php");
$email = $_SESSION['admin'];
if (isset($_POST['updateCoffee'])) {
	$sqlUpdateCoffee = "UPDATE cc_coffees SET name = ?, price = ?, milk = ?, cinnamon = ?, choco = ? WHERE code = ?";
	$stmtUpdateCoffee = $pdo -> prepare($sqlUpdateCoffee);
	$stmtUpdateCoffee -> execute([$_POST['name'], $_POST['price'], $_POST['milk'], $_POST['cinnamon'], $_POST['choco'], $_POST['code']]);
	header("location: ../system.php");
}
?>