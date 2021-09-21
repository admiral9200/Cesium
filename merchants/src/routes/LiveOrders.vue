<template>
	<div>
		<v-card v-for="newOrder in newOrders" :key="newOrder.id" class="d-flex justify-space-between my-3">
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
				<v-btn @click="ConfirmOrderToClient" :disable="newOrder.confirmed" large block color="primary" class="my-1 mx-0">
					Confirm
					<v-icon dark right size="22">mdi-checkbox-marked-circle</v-icon>
				</v-btn>
				<v-btn @click="CompleteOrder" large block color="success" class="my-1 mx-0">
					Deliver
					<v-icon dark right size="22">mdi-check-all</v-icon>
				</v-btn>
				<v-btn @click="CancelOrder" large block color="error" class="my-1 mx-0">
					Cancel
					<v-icon dark right size="22">mdi-minus-circle</v-icon>
				</v-btn>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
import { io } from 'socket.io-client';

export default {
	name: 'LiveOrders',

	data() {
		return {
			newOrders: []
		}
	},

	methods: {
		ConfirmOrderToClient: async function() {

		},

		CompleteOrder: async function() {

		},

		CancelOrder: async function() {

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
		// !Reminder: Change domain for socket in prod
		const socket = io('http://localhost:3000/', {
			transports: ["websocket"] 
		});

		socket.on("connect", () => {
			socket.emit("feed", this.$cookies.get('cc_b_id'));
		});

		socket.on("new_order", (new_order) => {
			this.newOrders.push(new_order);
		});
	},

	beforeRouteLeave (to, from, next) {
		const socket = io('http://localhost:3000/', {
			transports: ["websocket"] 
		});
		
		socket.emit("stopFeed");

		socket.on("disconnect", (reason) => {
			if (socket.disconnect && !socket.connected) {
				console.log(reason);
			}
		});
		next();
	}
}
</script>