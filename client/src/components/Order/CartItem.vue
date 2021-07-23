<template>
	<li class='list-group-item bg-light border-0 p-0 my-2'>
		<div class="row border-0">
			<div class="col-10">
				<p class="m-0">{{ cart.name }}</p>
				<p class='text-muted cc-p-font m-0'>{{ cart.size > 1 ? cart.size + 'πλος' : 'Μονός' }}, {{ cart.blends + ', ' + cart.sugar + ', ' + cart.sugarType }}</p>
				<p class="text-muted cc-p-font m-0">{{ }}</p>				
			</div>
			<div class="col-2">
				<button v-on:click="RemoveItemFromCart(cart._id)" type="button" class="btn-close btn-sm" aria-label="Remove Coffee"></button>
			</div>
		</div>
		<div class="row border-0 p-0 my-2">
			<div class='row user-select-none'>
				<div class='col-6 align-self-center'>
					<h6 class="m-0">{{ cart.price }}€</h6>
				</div>
				<div class='col-6 p-0 align-self-center'>
					<div class="input-group justify-content-end">
						<button v-on:click="quantityDecrease(cart._id)" :class="{ 'disabled': cart.qty <= 1 }" class="btn btn-sm cart_btn">-</button>
						<p class="m-0 mx-2 align-self-center">{{ cart.qty }}</p>
						<button v-on:click="quantityIncrease(cart._id)" class="btn btn-sm cart_btn">+</button>
					</div>
				</div>
			</div>
		</div>
	</li>
</template>

<script>
import NProgress from 'nprogress';

export default {
	name: 'CartItem',

	props: ['cart'],

	data() {
		return {
		}
	},

	methods: {
		quantityIncrease: async function(id) {
			const token = this.$cookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const response = await fetch('http://' + this.$store.state.base_url + ':3000/order/inc', {
						method: 'POST',
						headers: {
							"Content-type" : "application/json; charset=UTF-8",	
							"Authorization" : token,
						},
						body: JSON.stringify({
							user_id: this.$store.state.userInfo.id,
							product_id: id
						})
					});
					
					if (response.ok) {
						const res = await response.json();

						if (res.ok) {
							this.$root.$emit('Cart Update');
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Chip Coffee',
								text: res.error
							});
						}
					}
					else if (!response.ok){
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: 'Unexpected error: ' + response.status
						});
					}
				} 
				catch (error) {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: error
					});
				}
				finally {
					NProgress.inc();
				}
			}
		},

		quantityDecrease: async function(id) {
			const token = this.$cookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const response = await fetch('http://' + this.$store.state.base_url + ':3000/order/dec', {
						method: 'POST',
						headers: {
							"Content-type" : "application/json; charset=UTF-8",	
							"Authorization" : token,
						},
						body: JSON.stringify({
							user_id: this.$store.state.userInfo.id,
							product_id: id
						})
					});
					
					if (response.ok) {
						const res = await response.json();

						if (res.ok) {
							this.$root.$emit('Cart Update');
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Chip Coffee',
								text: res.error
							});
						}
					}
					else if (!response.ok){
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: 'Unexpected error: ' + response.status
						});
					}
				} 
				catch (error) {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: error
					});
				}
				finally {
					NProgress.inc();
				}
			}
		},

		RemoveItemFromCart: async function(id) {
			const token = this.$cookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const response = await fetch('http://' + this.$store.state.base_url + ':3000/order/del', {
						method: 'POST',
						headers: {
							"Content-type" : "application/json; charset=UTF-8",	
							"Authorization" : token,
						},
						body: JSON.stringify({
							user_id: this.$store.state.userInfo.id,
							product_id: id
						})
					});
					
					if (response.ok) {
						const res = await response.json();

						if (res.ok) {
							this.$root.$emit('Cart Update');

							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Chip Coffee',
								text: res.msg
							});
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Chip Coffee',
								text: res.error
							});
						}
					}
					else if (!response.ok){
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: 'Unexpected error: ' + response.status
						});
					}
				} 
				catch (error) {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: error
					});
				}
				finally {
					NProgress.inc();
				}
			}
		}
	},
}
</script>

<style scoped>
.cart_btn:focus {
	outline: none;
	box-shadow: none;
}

.cc-p-font {
	font-size: 0.9rem;
}
</style>