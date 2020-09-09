<?php
include("db_connect.php");
session_start();
if (!isset($_SESSION['email'])) header('location: index.php');
$email = $_SESSION['email'];
$sqlAddresses = "SELECT * FROM cc_address WHERE email = ?";
$stmtAddress = $pdo -> prepare($sqlAddresses);
$stmtAddress -> execute([$email]);
?>
<ul class="list-group list-group-flush">
	<li class="list-group-item mt-4 mb-4">
		<div class="row">
			<div class="col-xl-3 col-6">
				<h6>Διεύθυνση</h6>
			</div>
			<div class="col-xl-3 col-6">
				<h6>Περιοχή</h6>
			</div>
		</div>
	</li>
	<?php
	if ($stmtAddress -> rowCount() > 0){
		$i = 0;
		while ($row = $stmtAddress -> fetch()){
			$address = $row['address'];
			$state = $row['state'];
			?>
			<li class='list-group-item mt-2 mb-3'>
					<div class='row '>
						<div class='col-xl-3 col-6 align-middle'>
							<h6><?php echo $address; ?></h6>
						</div>
						<div class='col-xl-3 col-6 align-middle'>
							<h6><?php echo $state; ?></h6>
						</div>
						<div class='col-xl-2 col-12'>
							<a id="delete" class='btn btn-primary btn-block btn-danger' href='./php/address.php?address=<?php echo $address;?>' role='button'>Διαγραφή</a>
						</div>
					</div>
				</li>
			<?php
			$i += 1;
		}
	}
	else{
		?>
		<li class='list-group-item mt-2 mb-4'>
			<h6>Δεν υπάρχει ενεργή διεύθυνση</h6>
		</li>
		<?php
	}
	?>
</ul>