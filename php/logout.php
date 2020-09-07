<?php
session_start();
include("db_connect.php");
$email = $_SESSION['email'];
$sqlClearCart = "DELETE FROM cc_cart WHERE email = ?";
$stmtClearCart = $pdo -> prepare($sqlClearCart);
$stmtClearCart -> execute([$email]);
session_unset($email);
session_destroy();
header("location: ../");
?>