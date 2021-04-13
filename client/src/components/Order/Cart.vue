<template>
	<div class="card sticky-top cart">
		<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
			<h5>${ coffeeInCart.coffee }</h5>
			<a onclick="deleteCoffee(${ keys[i] })" type='button' class='btn btn-sm btn-outline-danger mr-2' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></a>
		</li>
		<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 pt-0 mt-0'>
			<p class='attr'>
				${ coffeeInCart.sugar }
				${ coffeeInCart.sugarType !== '' ? ', ' + coffeeInCart.sugarType : '' }
				${ coffeeInCart.milk === 1 ? ', Γάλα' : '' }
				${ coffeeInCart.cinnamon === 1 ? ', Κανέλα' : '' }
				${ coffeeInCart.choco === 1 ? ', Σκόνη Σοκολάτας' : '' }
			</p>
		</li>
		<li>
			<div class='row d-flex justify-content-center user-select-none'>
				<div class='col-4 d-flex justify-content-center mt-3'>
					<h5>${ price.toFixed(2) }€</h5>
				</div>
				<div class='col-8'>
					<div class='qty d-flex justify-content-center mt-2'>
						<a type='button' class='minus' onclick="quantityHelper(${ keys[i] }, 'minus')" id="minus">-</a>
						<input type='number' class='count' name='qty' value="${ coffeeInCart.qty }" disabled>
						<a type='button' class='plus' onclick="quantityHelper(${ keys[i] }, 'plus')" id="plus">+</a>
					</div>
				</div>
			</div>
		</li>
	</div>
</template>

<script>
export default {

}
</script>

<style scoped>
.card {
	border: none;
}
</style>