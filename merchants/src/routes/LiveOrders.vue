<template>
	<v-scale-transition v-if="newOrders.length > 0" group>
		<v-card :loading="newOrder.loaderInCard" v-for="newOrder in newOrders" :key="newOrder.id" class="d-flex justify-space-between my-3 pa-1 rounded-xl">
			<div class="d-flex flex-column justify-center">
				<v-card-title>Order ID: {{ newOrder.id }}</v-card-title>
				<v-card-subtitle>Date: {{ newOrder.date }}</v-card-subtitle>
			</div>
			<div class="d-flex flex-column">
				<v-card-title class="pl-0">{{ newOrder.user.name + ' ' + newOrder.user.surname }}</v-card-title>
				<p class="my-1">{{ newOrder.user.email }}</p>
				<p class="my-1">{{ newOrder.user.address.route + ' ' + newOrder.user.address.street_number + ', ' + newOrder.user.address.locality + ' ' + newOrder.user.address.postal_code }}</p>
			</div>
			<div class="d-flex flex-column">
				<v-card-title class="pl-0">Order Info</v-card-title>
				<p class="my-1">Payment method: {{ newOrder.user.payment }}</p>
				<p class="my-1">Apartment: {{ newOrder.user.ringbell + ' ' + newOrder.user.floor }}</p>
				<p class="my-1">Mobile: {{ newOrder.user.phone }}</p>
				<p class="my-1">Comments: {{ newOrder.user.comments }}</p>
			</div>
			<div class="d-flex flex-column">
				<v-card-title class="pl-0">Contents</v-card-title>
				<v-card outlined v-for="product in newOrder.cart" :key="product._id" class="d-flex justify-space-between pa-2 ma-1">
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
							<v-btn @click="ConfirmOrderToClient(newOrder)" :disabled="newOrder.confirmed" large block color="primary" class="my-1 mx-0">
								Confirm
								<v-icon dark right size="22">mdi-checkbox-marked-circle</v-icon>
							</v-btn>
						</div>
					</template>
					<span>You have confirmed this order!</span>
				</v-tooltip>
				<v-btn @click="CompleteOrder(newOrder)" large block color="success" class="my-1 mx-0">
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
					<v-form ref="form" @submit.prevent="CancelOrder(newOrder)" lazy-validation>
						<v-card>
							<v-card-title>
								<span class="text-h5">Reason for cancelling order {{ newOrder.id }}</span>
							</v-card-title>

							<v-card-text>
								<v-col cols="12">
									<v-text-field
										v-model="newOrder.cancelledReason"
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
		<h2>No new orders</h2>
	</v-scale-transition>
</template>

<script>
import { io } from 'socket.io-client';

export default {
	name: 'LiveOrders',

	data() {
		return {
			newOrders: [],
			show: false,
			ReasonRules: [
				v => !!v || 'Name is required'	
			]
		}
	},

	methods: {
		ConfirmOrderToClient: function(order) {
			const socket = io('http://' + this.$store.state.base_url + ':3000', {
				transports: ["websocket"] 
			});

			order.loaderInCard = true;
			socket.on("connect", () => socket.emit("merchant:order:confirm", this.$cookies.get('cc_b_id'), order.id));
		},

		CancelOrder: function(order) {
			if (order.cancelledReason !== '') {
				const socket = io('http://' + this.$store.state.base_url + ':3000', {
					transports: ["websocket"] 
				});

				order.loaderInCard = true;
				socket.on("connect", () => socket.emit("merchant:order:cancel", this.$cookies.get('cc_b_id'), order));
			}
		},

		CompleteOrder: function(order) {
			order.loaderInCard = true;
		}
	},

	async created() {
		try {
			const response = await fetch('http://' + this.$store.state.base_url + ':3000/m/store/feed', {
				method: 'GET',
				headers: {
					"Authorization" : this.$cookies.get('cc_b_id'),
					"Content-type" : "application/json; charset=UTF-8"
				}
			});

			if (response.ok) {
				const res = await response.json();

				if (res.tokenExpired || res.tokenMalformed) {
					this.TokenExpiredHelper();

					this.$notify({
						group: 'main',
						type: 'error',
						title: 'Cofy',
						text: res.message
					});
				}

				if (!res.no_new_orders && res.new_orders.length > 0) {
					res.new_orders.forEach(order => {
						this.newOrders.push(order);
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
		finally {
			const socket = io('http://' + this.$store.state.base_url + ':3000', {
				transports: ["websocket"] 
			});

			socket.on("connect", () => socket.emit("merchant:feed", this.$cookies.get('cc_b_id')));

			socket.on("merchant:new_order:add", (new_order) => {
				try {
					new Audio('/assets/cc_notification2.mp3').play();	
				} 
				finally {
					this.newOrders.push(new_order);
				}
			});

			socket.on('merchant:new_order:remove', (old_val) => {
				let removeIndex = this.newOrders.map(order => order.id).indexOf(old_val.id);
				~removeIndex && this.newOrders.splice(removeIndex, 1);
			});

			socket.on('merchant:new_order:change', (order_id) => {
				this.newOrders.find(order => {
					if (order.id === order_id) {
						order.confirmed = true;
						order.loaderInCard = false;
					}
				});
			});

			socket.on('merchant:order:cancelled', () => {

			});
		}
	},

	beforeRouteLeave (to, from, next) {
		const socket = io('http://' + this.$store.state.base_url + ':3000', {
			transports: ["websocket"] 
		});
		
		socket.emit("merchant:stopFeed");

		socket.on("disconnect", (reason) => {
			if (socket.disconnect && !socket.connected) {
				console.log(reason);
			}
		});
		next();
	}
}
</script>