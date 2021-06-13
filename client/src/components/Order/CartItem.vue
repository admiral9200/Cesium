<template>
	<li vfo class='list-group-item bg-light border-0 p-0 my-3'>
		<div class="row border-0">
			<div class="col-10">
				<p class="m-0">{{ cart.name }}</p>
				<p class='text-muted m-0'>{{ cart.sugar }}</p>
			</div>
			<div class="col-2">
				<button v-on:click="RemoveItemFromCart" type="button" class="btn-close btn-sm" aria-label="Remove Coffee"></button>
			</div>
		</div>
		<div class="row border-0 p-0 my-2">
			<div class='row user-select-none'>
				<div class='col-6 align-self-center'>
					<h6 class="m-0">2.20€</h6>
				</div>
				<div class='col-6 p-0 align-self-center'>
					<div class="input-group justify-content-end">
						<button v-on:click="quantityDecrease" class="btn btn-sm cart_btn">-</button>
						<p class="m-0 mx-2 align-self-center">{{ quantity }}</p>
						<button v-on:click="quantityIncrease" class="btn btn-sm cart_btn">+</button>
					</div>
				</div>
			</div>
		</div>
	</li>
</template>

<script>
export default {
	name: 'CartItem',

	props: ['cart'],

	data() {
		return {
			quantity: 1
		}
	},

	mounted() {
		console.log(this.cart[0].name);
	},

	methods: {
		quantityIncrease: function() {

		},

		quantityDecrease: function() {
			
		},

		RemoveItemFromCart: function() {
			
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