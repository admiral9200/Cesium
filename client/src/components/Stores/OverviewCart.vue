<template>
	<div class="my-3">
		<b-button-group>
			<b-button button variant="none" class="mainbtn" to="/order">
				<b-icon icon="arrow-left"></b-icon>
				Πίσω στο μενού
			</b-button>
			<b-button button variant="none" class="mainbtn" v-b-toggle.CartView>
				<b-icon icon="cart-fill"></b-icon>
				Το καλάθι σου
			</b-button>
		</b-button-group>
		<b-sidebar id="CartView" title="Το καλάθι σου" shadow backdrop lazy>
			<CartItem v-for="(cart, index) in UserCartProducts" :key="index" :cart="cart" class="p-3"/>
		</b-sidebar>
	</div>
</template>

<script>
import router from '../../router';
import CartItem from '../Order/CartItem.vue';

export default {
	name: 'OverviewCart',

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

	watch: {
		UserCartProducts: function(cart) {
			if (cart.length === 0) {
				router.push('/order');
			}
		}
	}
}
</script>