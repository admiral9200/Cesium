<template>
	<v-scale-transition v-if="MerchantOrders.length > 0" group>
		<v-card :loading="order.loaderInCard" v-for="order in MerchantOrders" :key="order.id" class="d-flex justify-space-between my-3 rounded-xl">
			<div class="d-flex flex-column justify-center">
				<v-card-title>Order ID: {{ order.id }}</v-card-title>
				<v-card-subtitle>Date: {{ order.date }}</v-card-subtitle>
			</div>
			<div class="d-flex flex-column">
				<v-card-title class="pl-0">{{ order.user.name + ' ' + order.user.surname }}</v-card-title>
				<p class="my-1">{{ order.user.email }}</p>
				<p class="my-1">{{ order.user.address.route + ' ' + order.user.address.street_number + ', ' + order.user.address.locality + ' ' + order.user.address.postal_code }}</p>
			</div>
			<div class="d-flex flex-column">
				<v-card-title class="pl-0">Order Info</v-card-title>
				<p class="my-1">Payment method: {{ order.user.payment }}</p>
				<p class="my-1">Apartment: {{ order.user.ringbell + ' ' + order.user.floor }}</p>
				<p class="my-1">Mobile: {{ order.user.phone }}</p>
				<p class="my-1">Comments: {{ order.user.comments }}</p>
			</div>
			<div class="d-flex flex-column">
				<v-card-title class="pl-0">Contents</v-card-title>
				<v-card outlined v-for="product in order.cart" :key="product._id" class="d-flex justify-space-between pa-2 ma-1">
					<div>
						<p class="ma-1">{{ product.name + ' x' + product.qty }}</p>
						<p class='ma-1'>{{ product.size > 1 ? product.size + 'πλος' : 'Μονός' }}, {{ product.blends + ', ' + product.sugar + ', ' + product.sugarType }}</p>
						<p class="ma-1">Decaf: {{ product.decaf ? 'YES' : 'NO'}}</p>
						<v-list v-if="product.adds.length > 0" dense class="pa-0">
							<v-list-item-title class="mx-1">Adds</v-list-item-title>
							<v-list-item>
								<v-list-item-content v-for="(add, index) in product.adds" :key="index">
									<v-list-item-title>{{ add }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						</v-list>
						<v-list v-if="product.extras.length > 0" dense class="pa-0">
							<v-list-item-title class="ma-1">Extras</v-list-item-title>
							<v-list-item>
								<v-list-item-content v-for="(add, index) in product.adds" :key="index">
									<v-list-item-title>{{ add }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						</v-list>
					</div>
					<div>
						<p>{{ product.price }}€</p>
					</div>
				</v-card>
			</div>
			<v-card-actions class="d-flex flex-column align-self-start justify-center">
				<v-tooltip left>
					<template v-slot:activator="{ on }">
						<div v-on="on">
							<v-btn @click="ConfirmOrderToClient(order)" :disabled="order.confirmed" large block color="primary" class="my-1 mx-0">
								Confirm
								<v-icon dark right size="22">mdi-checkbox-marked-circle</v-icon>
							</v-btn>
						</div>
					</template>
					<span>You have confirmed this order!</span>
				</v-tooltip>
				<v-btn @click="CompleteOrder(order)" large block color="success" class="my-1 mx-0">
					Deliver
					<v-icon dark right size="22">mdi-check-all</v-icon>
				</v-btn>
				<v-dialog max-width="550px">
					<template v-slot:activator="{ on, attrs }">
						<v-btn large block color="error" class="my-1 mx-0" v-bind="attrs" v-on="on">
							Cancel
							<v-icon dark right size="22">mdi-minus-circle</v-icon>
						</v-btn>
					</template>
					<v-form ref="form" @submit.prevent="CancelOrder(order)" lazy-validation>
						<v-card>
							<v-card-title>
								<span class="text-h5">Reason for cancelling order {{ order.id }}</span>
							</v-card-title>

							<v-card-text>
								<v-col cols="12">
									<v-text-field
										v-model="order.cancelledReason"
										:rules="ReasonRules"
										label="Reason" 
										required>
									</v-text-field>
								</v-col>
							</v-card-text>

							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" type="submit">Submit</v-btn>
							</v-card-actions>
						</v-card>
					</v-form>
				</v-dialog>
			</v-card-actions>
		</v-card>
	</v-scale-transition>
	<v-scale-transition v-else>
		<h2>There are no orders</h2>
	</v-scale-transition>
</template>

<script>
export default {
	data() {
		return {
			MerchantOrders: []
		}
	},

	async created() {
		try {
			const response = await fetch('http://' + this.$store.state.base_url + ':3000/m/store/orders', {
				method: 'GET',
				headers: {
					"Authorization" : this.$cookies.get('cc_b_id'),
					"Content-type" : "application/json; charset=UTF-8"
				}
			});

			if (response.ok) {
				const res = await response.json();

				if (res.error) {
					if ('tokenMalformed' in res.error) {
						this.sessionExpiredHandler(res.error.message);
					}
				}

				if (!res.no_new_orders && res.new_orders.length > 0) {
					res.new_orders.forEach(order => {
						this.orders.push(order);
					});
				}
			}
		} 
		catch (error) {
			this.$notify({
				group: 'main',
				type: 'error',
				title: 'Error',
				text: error
			});
		}
	},
}
</script>

<style>

</style>