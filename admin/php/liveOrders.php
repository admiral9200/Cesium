<?php
session_start();
if (!isset($_SESSION['admin'])) {
    session_destroy();
    header('location: ../');
}
include_once("db.php");
$sqlCheckout = "SELECT * FROM cc_checkout";
$stmtCheckout = $pdo->prepare($sqlCheckout);
$stmtCheckout->execute();
$sqlOrdersExists = "SELECT COUNT(id) AS OrdersExists FROM cc_ordersBackendPanel";
$stmtOrdersExists = $pdo->prepare($sqlOrdersExists);
$stmtOrdersExists->execute();
if (($stmtCheckout->rowCount() > 0) && ($stmtOrdersExists->rowCount() > 0)) {
	while ($rowCheckout = $stmtCheckout->fetch()) {
		$id = $rowCheckout['id'];
		$email = $rowCheckout['email'];
		$sqlUserName = "SELECT firstName, lastName FROM cc_users WHERE email = ?";
		$stmtUserName = $pdo->prepare($sqlUserName);
		$stmtUserName->execute([$email]);
		$rowUserName = $stmtUserName->fetch();
		$sqlAddress = "SELECT address, state FROM cc_address WHERE email = ?";
		$stmtAddress = $pdo -> prepare($sqlAddress);
		$stmtAddress -> execute([$email]);
		$rowAddress = $stmtAddress -> fetch();
		$address = $rowAddress['address'];
		$state = $rowAddress['state'];
		$firstName = $rowUserName['firstName'];
		$lastName = $rowUserName['lastName'];
		$doorname = $rowCheckout['doorname'];
		$floor = $rowCheckout['floor'];
		$phone = $rowCheckout['phone'];
		$comment = $rowCheckout['comment'];
		$date = $rowCheckout['date'];
		$time = $rowCheckout['time'];
		?>
		<div class="card mb-3">
			<div class="card-body row">
				<div class="col-xl-1">
					<p><?php echo $id; ?></p>
				</div>
				<div class="col-xl-2">
					<h6><?php echo $firstName . " " . $lastName; ?></h6>
					<p><?php echo $email; ?></p>
				</div>
				<div class="col-xl-1">
					<p><?php echo $address ." ". $state; ?></p>
				</div>
				<div class="col-xl-2">
					<p><?php echo $doorname . " " . $floor . " - " . $phone; ?></p>
					<p><?php echo $comment; ?></p>
				</div>
				<div class="col-xl-1">
					<p><?php echo $date; ?></p>
					<p><?php echo $time; ?></p>
				</div>
				<div class="col-xl-2">
					<?php
					$totalCost = 0;
					$sqlBackendOrders = "SELECT coffee, sugar, sugarType, milk, cinnamon, choco, price, qty FROM cc_ordersBackendPanel WHERE id = ?";
					$stmtOrdersPanel = $pdo->prepare($sqlBackendOrders);
					$stmtOrdersPanel->execute([$id]);
					while ($rowOrder = $stmtOrdersPanel->fetch()) {
						$coffee = $rowOrder['coffee'];
						$sugar = $rowOrder['sugar'];
						$sugarType = $rowOrder['sugarType'];
						$milk = $rowOrder['milk'];
						$cinnamon = $rowOrder['cinnamon'];
						$choco = $rowOrder['choco'];
						$price = $rowOrder['price'];
						$totalCost += $price;
						$qty = $rowOrder['qty'];
					?>
						<h5 class="mb-0"><?php echo $qty . "x " . $coffee ?></h5>
						<p class="sz">
							<?php echo $sugar . ", " . $sugarType;
							if ($milk == 1) echo ", Γάλα";
							if ($cinnamon == 1) echo ", Κάνελα";
							if ($choco == 1) echo ", Σκόνη Σοκολάτας";
							?>
						</p>
					<?php
					}
					?>
				</div>
				<div class="col-xl-1">
					<h6>
						<?php
						$costString = sprintf("%0.2f", $totalCost);
						echo $costString;
						?>
					</h6>
				</div>
				<div class="col-xl-2">
					<form action="./php/deleteOrder.php" method="POST">
						<button value="<?php echo $id; ?>" name="deleteOrder" class="btn btn-primary btn-lg btn-block">Execute</button>
					</form>
				</div>
			</div>
		</div>
	<?php
	}
} 
else {
	echo "<h1>All good! No new orders</h1>";
}