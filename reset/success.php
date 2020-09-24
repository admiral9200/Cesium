<?php
session_start();
if(!isset($_SESSION['reset'])) header("location: ./");
unset($_SESSION['reset']);
?>
<div class="alert alert-success" role="alert">
	<div class="text-center">
		<img src="../images/success.png" class="rounded chk" alt="Success">
	</div>
	<h2 class="alert-heading space">Η επαναφορά του κωδικού σου ήταν επιτυχής</h2>
</div>