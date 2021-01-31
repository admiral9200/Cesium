<?php
session_start();
include("db.php");
if (!isset($_SESSION['admin'])) {
    session_destroy();
    header('location: ../');
}
if (isset($_POST['deleteOrder'])) {
	$id = $_POST['deleteOrder'];
	$sqlExecutedOrder = "UPDATE cc_orders SET executed = 1 WHERE id = ?";
	$stmtExecuteOrder = $pdo -> prepare($sqlExecutedOrder);
	$stmtExecuteOrder -> execute([$id]);
	header("location: ../dashboard.php");
}
?>