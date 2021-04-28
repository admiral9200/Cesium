<template>
	<li class='list-group-item bg-light border-0 p-0 my-3'>
		<div class="row border-0">
			<div class="col-10">
				<p class="m-0">Espresso</p>
				<p class='text-muted m-0'>Γλυκός, Κανέλα</p>
			</div>
			<div class="col-2">
				<button type="button" class="btn-close btn-sm" aria-label="Close"></button>
			</div>
		</div>
		<div class="row border-0 p-0 my-2">
			<div class='row user-select-none'>
				<div class='col-6 align-self-center'>
					<h6 class="m-0">2.20€</h6>
				</div>
				<div class='col-6 p-0 align-self-center'>
					<div class="input-group justify-content-end">
						<button v-on:click="quantityMinus" class="btn btn-sm cart_btn">-</button>
						<p class="m-0 mx-2 align-self-center">{{ quantity }}</p>
						<button v-on:click="quantity++" class="btn btn-sm cart_btn">+</button>
					</div>
				</div>
			</div>
		</div>
	</li>
</template>

<script>
export default {
	name: 'CartItem',

	data() {
		return {
			quantity: 1
		}
	},

	methods: {
		quantityMinus: function() {
			if (this.quantity > 1) this.quantity--;
		}
	},
}
</script>

<style scoped>
.cart_btn:focus {
	outline: none;
	box-shadow: none;
}
</style>