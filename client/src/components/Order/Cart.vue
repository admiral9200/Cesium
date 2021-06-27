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
import store from '../../store/store';
import CartItem from './CartItem';
import NProgress from 'nprogress';

export default {
	name: 'Cart',

	components: {
		CartItem
	},

	computed: {
		UserCartProducts() {
			try {
				return this.$store.state.userCart.products;
			} 
			catch {
				return [];
			}
		}
	},

	mounted() {
		this.$root.$on('Cart Update', async () => {
			await store.dispatch('fetchUserCart')
			NProgress.done();
		});
	},

	destroyed() {
		this.$root.$off;
	}
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