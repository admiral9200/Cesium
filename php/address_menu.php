<?php
include("db_connect.php");
session_start();
if (!isset($_SESSION['email'])) header('location: index.php');
$email = $_SESSION['email'];
$sqlAddresses = "SELECT * FROM cc_address WHERE email = ?";
$stmtAddress = $pdo -> prepare($sqlAddresses);
$stmtAddress -> execute([$email]);
if($stmtAddress -> rowCount() == 0){
	?>
	<h2>Έχεις όρεξη για καφέ; Πρόσθεσε τη διεύθυνση σου και παράγγειλε!</h2>
	<form class="form-group pr-0 m-0">
		<div class="row">
			<div class="group col-xl-5 col-12 mt-2 m-xl-0">   
				<input id="address" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου" required>
				<div class="text-danger">
					Πρέπει να συμπληρώσεις την διεύθυνσή σου.
				</div>
			</div>
			<div class="group col-xl-5 col-12 mt-2 m-xl-0">
				<input id="state" type="text" class="input form-control form-control-lg w-100" placeholder="Πρόσθεσε εδώ την περιοχή σου" required>
				<div class="text-danger">
					Πρέπει να συμπληρώσεις την περιοχή σου.
				</div>
			</div>
			<div class="group col-xl-2 col-12 mt-2 m-xl-0">
				<button id="add" name="add" type="submit" class="btn btn-primary btn-lg btn-block">Προσθήκη</button>
			</div>
		</div>
	</form>
<?php
}
else{
	?>
	<button class="btn btn-primary btn-lg btn-block" role="button" onclick="location.href='order.php'" >Παράγγειλε τώρα</button>       
	<?php
}
?>