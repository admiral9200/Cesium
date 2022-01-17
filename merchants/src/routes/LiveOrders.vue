<template>
	<v-scale-transition v-if="newOrders.length > 0" group>
		<v-card :loading="newOrder.loaderInCard" v-for="newOrder in newOrders" :key="newOrder.id" class="d-flex justify-space-between my-3 rounded-xl">
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

				<v-tooltip left :disabled="!newOrder.confirmed">
					<template v-slot:activator="{ on }">
						<div v-on="on">
							<v-btn @click="OrderConfirmed(newOrder)" :disabled="newOrder.confirmed" large block color="primary" class="my-1 mx-0">
								Confirm<v-icon dark right size="22">mdi-checkbox-marked-circle</v-icon>
							</v-btn>
						</div>
					</template>
					<span>You have confirmed this order!</span>
				</v-tooltip>

				<v-btn @click="OrderDelivered(newOrder)" large block color="success" class="my-1 mx-0">
					Deliver<v-icon dark right size="22">mdi-check-all</v-icon>
				</v-btn>

				<OrderCancel 
					:order="newOrder" 
					@remove_cancelled_order="removeCancelledOrder"
				/>
			</v-card-actions>
		</v-card>
	</v-scale-transition>
	<v-scale-transition v-else>
		<h2>No new orders</h2>
	</v-scale-transition>
</template>

<script>
import OrderCancel from '../components/LiveOrders/OrderCancel.vue';
import { io } from 'socket.io-client';

export default {
	name: 'LiveOrders',

	components: {
		OrderCancel
	},

	data() {
		return {
			newOrders: []
		}
	},

	methods: {
		removeCancelledOrder: function (orderToCancel) {
			let removeIndex = this.newOrders.map(order => order.id).indexOf(orderToCancel);
			~removeIndex && this.newOrders.splice(removeIndex, 1);
		},

		OrderConfirmed: async function(order) {
			order.loaderInCard = true;

			try {
				const response = await fetch('http://' + this.$store.state.base_url + ':3000/m/order/confirm', {
					method: 'POST',
					headers: {
						"Authorization" : this.$cookies.get('cc_b_id'),
						"Content-type" : "application/json; charset=UTF-8"
					},
					body: JSON.stringify({
						'order': order.id
					}),
				});

				if (response.ok) {
					let OrderStatus = await response.json();

					if (OrderStatus.error) {
						if ('tokenMalformed' in OrderStatus.error) {
							this.sessionExpiredHandler(OrderStatus.error.message);
						}
					}

					if (OrderStatus.confirmed) {
						order.confirmed = true;
						this.$notify({
							group: 'main',
							type: 'success',
							title: 'Order Status',
							text: 'Order confirmed successfully. Client has been notified'
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
				order.loaderInCard = false;
			}
		},

		OrderDelivered: async function(order) {
			order.loaderInCard = true;

			try {
				const response = await fetch('http://' + this.$store.state.base_url + ':3000/m/order/deliver', {
					method: 'POST',
					headers: {
						"Authorization" : this.$cookies.get('cc_b_id'),
						"Content-type" : "application/json; charset=UTF-8"
					},
					body: JSON.stringify({
						'order': order.id
					}),
				});

				if (response.ok) {
					let orderStatus = await response.json();

					if (orderStatus.error) {
						if ('tokenMalformed' in orderStatus.error) {
							this.sessionExpiredHandler(orderStatus.error.message);
						}
					}

					if (orderStatus.completed) {
						let removeIndex = this.newOrders.map(order => order.id).indexOf(order.id);
						~removeIndex && this.newOrders.splice(removeIndex, 1);
						order.loaderInCard = false;
						this.$notify({
							group: 'main',
							type: 'success',
							title: 'Order Status',
							text: 'Order completed successfully'
						});
					}

					if (orderStatus.error) {
						this.$notify({
							group: 'main',
							type: 'error',
							title: 'Error',
							text: orderStatus.error
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
				order.loaderInCard = false;
			}
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

				if (res.error) {
					if ('tokenMalformed' in res.error) {
						this.sessionExpiredHandler(res.error.message);
					}
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

		const token = this.$cookies.get('cc_b_id');

		const socket = io('http://' + this.$store.state.base_url + ':3000', {
			transports: ["websocket"],
			query: {
				token
			}
		});

		socket.on("connect", () => socket.emit("merchant:feed"));

		socket.on("merchant:order:add", (new_order) => {
			try {
				new Audio('/assets/cc_notification2.mp3').play();	
			} 
			finally {
				this.newOrders.unshift(new_order);
			}
		});

		socket.on('merchant:order:deleted', (order_id) => this.removeCancelledOrder(order_id));
	},

	beforeRouteLeave (to, from, next) {
		const token = this.$cookies.get('cc_b_id');
		
		const socket = io('http://' + this.$store.state.base_url + ':3000', {
			transports: ["websocket"],
			query: {
				token
			}
		});
		
		socket.emit("merchant:stopFeed");

		socket.on("disconnect");

		next();
	}
}
</script>