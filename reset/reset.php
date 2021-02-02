<?php
error_reporting(E_NOTICE);
session_start();
require("../config/db.connect.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset']) && isset($_POST['email'])){
	$email = $_POST['email'];
	$res = validateEmail($email);
	echo $res;
}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && !is_null($_POST['submit']) && !empty($_POST['newPass']) && !empty($_POST['confirm'])){
	$newPass = $_POST['newPass'];
	$confirm = $_POST['confirm'];
	$res = validatePasswords($newPass, $confirm);
	echo $res;
}
else{
	echo false;
}

function validateEmail($email){
	global $pdo;
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$sqlCheckEmail = "SELECT email FROM cc_users WHERE email = ?";
		$stmtEmailCheck = $pdo -> prepare($sqlCheckEmail);
		$stmtEmailCheck -> execute([$email]);
		if($stmtEmailCheck){
			if ($stmtEmailCheck -> rowCount() == 1) {
				$_SESSION['reset'] = $email;
				return true;
			}
			else{
				return "Η διεύθυνση αυτή δεν υπάρχει.";
			}
		}
		else{
			return false;
		}
	}
	else{
		return "Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.";
	}
}

function validatePasswords($newPass, $confirm){
	global $pdo;
	$email = $_SESSION['reset'];
	if ($newPass === $confirm) {
		$newPass = password_hash($newPass, PASSWORD_DEFAULT);
		$sqlNewPass = "UPDATE cc_users SET password = ? WHERE email = ?";
		$stmtNewPass = $pdo -> prepare($sqlNewPass);
		$stmtNewPass -> execute([$newPass, $email]);
		if($stmtNewPass){
			return true;
		}
		else{
			return false;
		}
	}
}