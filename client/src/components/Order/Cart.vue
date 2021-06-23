<template>
	<div class="card sticky-top bg-light shadow-sm p-3 m-3">
		<h5 class='my-2 text-center'>Το καλάθι σου</h5>
		<div v-if="UserCartProducts === null || UserCartProducts.length < 1" class="my-5 d-grid">
			<img src="/images/cc_cup.png" class="cup mx-auto">
			<p class="text-center">Βάλε προϊόντα στο καλάθι σου από το μενού στα αριστερά</p>
		</div>
		<CartItem 
			v-else 
			v-for="(cart, index) in UserCartProducts" 
			:key="index" 
			:cart="cart"/>
		<router-link to="/stores" class="mainbtn btn my-3" :class="{ disabled: UserCartProducts === null || UserCartProducts.length < 1 }">Συνέχεια</router-link>
	</div>
</template>

<script>
import CartItem from './CartItem';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Cart',

	components: {
		CartItem
	},

	computed: {
		UserCartProducts() {
			try {
				return this.$store.state.userCart;
			} 
			catch {
				return [];
			}
		}
	},

	mounted() {
		this.$root.$on('Cart Update', () => this.fetchCart());
	},

	created() {
		this.fetchCart();
	},

	destroyed() {
		this.$root.$off;
	},

	methods: {
		fetchCart: async function() {
			const token = VueCookies.get('token');
			if (token) {
				NProgress.start();

				try {
					const response = await fetch('http://localhost:3000/order/cart', {
						method: 'GET',
						headers: {
							"Authorization" : token,
						}
					});
					
					if (response.ok) {
						const res = await response.json();

						if (res.cart) {
							this.$store.state.userCart = res.cart;
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: 'Unexpected error: ' + res.error
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
					NProgress.done();
				}
			}
		}
	},
}
</script>

<style scoped>
.cup {
	height: auto;
	width: 25px;
}

.card {
	border: none;
}
</style>