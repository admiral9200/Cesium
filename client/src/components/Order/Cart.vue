<template>
	<div class="card sticky-top">
		<h5 class='my-4'>Το καλάθι σου</h5>
		<li class='row border-0'>
			<div class="col-10">
				<p class="m-0">Espresso</p>
				<p class='text-muted m-0'>Γλυκός, Κανέλα</p>
			</div>
			<div class="col-2">
				<button type="button" class="btn-close" aria-label="Close"></button>
			</div>
		</li>
		<li class='list-group-item border-0 p-0 my-2'>
			<div class='row user-select-none'>
				<div class='col-7 align-self-center'>
					<h6 class="m-0">2.20€</h6>
				</div>
				<div class='col-5 align-self-center'>
					<div class="input-group">
						<button class="cart_btn btn btn-sm rounded-circle">-</button>
						<p class="m-0 mx-2 align-self-center">1</p>
						<button class="cart_btn btn btn-sm rounded-circle">+</button>
					</div>
				</div>
			</div>
		</li>
		<button class="mainbtn btn my-3" disabled>Συνέχεια</button>
	</div>
</template>

<script>
export default {
	
}
</script>

<style scoped>
.cart_btn {
	
}

.card {
	border: none;
}
</style>