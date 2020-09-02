<?php
session_start();
include("db.php");
if (!isset($_SESSION['email'])) {
    session_destroy();
    header('location: index.php');
}
if (isset($_POST['deleteOrder'])) {
	$id = $_POST['deleteOrder'];
	$sqldeleteCheckout = "DELETE FROM cc_checkout WHERE id = ?";
	$stmtDltCheckout = $pdo -> prepare($sqldeleteCheckout);
	$stmtDltCheckout -> execute([$id]);
	$sqlDeleteOrderPanel = "DELETE FROM cc_ordersBackendPanel WHERE id = ?";
	$stmtDeleteOrderfromPanel = $pdo -> prepare($sqlDeleteOrderPanel);
	$stmtDeleteOrderfromPanel -> execute([$id]);
	header("location: ../dashboard.php");
	die();
}