<?php
include("db_connect.php");
session_start();
$email = $_SESSION['email'];
$sqlClearCart = "DELETE FROM cc_cart WHERE email = ?";
$stmtClearCart = $pdo -> prepare($sqlClearCart);
$stmtClearCart -> execute([$email]);
?>