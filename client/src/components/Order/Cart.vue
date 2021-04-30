<template>
	<div class="card sticky-top bg-light shadow-sm p-3 m-3">
		<h5 class='my-2 text-center'>Το καλάθι σου</h5>
		<div v-if="UserCart === null" class="my-5 d-grid">
			<img src="/images/cc_cup.png" class="cup mx-auto">
			<p class="text-center">Βάλε προϊόντα στο καλάθι σου από το μενού στα αριστερά</p>
		</div>
		<CartItem v-else :userCart="UserCart"/>
		<router-link to="/checkout" class="mainbtn btn my-3" :class="{ disabled: UserCart === null }">Συνέχεια</router-link>
	</div>
</template>

<script>
import CartItem from './CartItem';

export default {
	name: 'Cart',

	components: {
		CartItem
	},

	computed: {
		UserCart() {
			return this.$store.state.userCart;
		}
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