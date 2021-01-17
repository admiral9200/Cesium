<h3 class="mt-3 mb-3">Το καλάθι σου</h3>
<ul class="list-group list-group-flush list">
	<?php
	if ($stmtCart->rowCount() >= 1) {
		while ($rowCart = $stmtCart->fetch()) {
			$totalCost += $price;
			?>
			<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
				<h5><?php echo $coffee; ?></h5>
				<a onclick="deleteCoffee(<?php echo $count; ?>)" type='button' class='btn btn-sm btn-outline-danger mr-2' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></a>
			</li>
			<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 pt-0 mt-0'>
				<p class='attr'>
					<?php
					echo $sugar;
					if (!empty($sugarType)) echo ", " . $sugarType;
					if ($milk == 1) echo ", Γάλα";
					if ($cinnamon == 1) echo ", Κανέλα";
					if ($choco == 1) echo ", Σκόνη Σοκολάτας";
					?>
				</p>
			</li>
			<li>
				<div class='row d-flex justify-content-center'>
					<div class='col-4 d-flex justify-content-center mt-3'>
						<h6><?php echo $price; ?>€</h6>
					</div>
					<div class='col-8'>
						<div class='qty d-flex justify-content-center mt-2'>
							<a class='minus' <?php if ($quantity > 1) {?> onclick="quantity(<?php echo $count; ?>, 'minus')" <?php } ?> id="minus">-</a>
							<input type='number' class='count' name='qty' value="<?php echo $quantity; ?>" disabled>
							<a class='plus' onclick="quantity(<?php echo $count; ?>, 'plus')" id="plus">+</a>
						</div>
					</div>
				</div>
			</li>
		<?php
		}
	} 
	else {
		?>
		<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
			<h6>Το καλάθι σου είναι άδειο</h6>
		</li>
		<?php
	}
	?>
	<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 mt-5">
		<h6 class="m-0">Συνολικό Κόστος</h6>
		<h6 class="m-0">
			<?php
			$costString = sprintf("%0.2f", $totalCost);
			echo $costString;
			?>
			€
		</h6>
	</li>
</ul>
<button type="button" name="continue" class="btn mainbtn text-white btn-block btn-lg" <?php if ($count == 0) echo "style='cursor: not-allowed' disabled"; else { ?> onclick="location.href='/checkout/';" <?php } ?>>Συνέχεια</button>