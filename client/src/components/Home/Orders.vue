<template>
	<div>
		<li v-if="hasNoOrders" class='list-group-item mt-2 mb-4 border-0'>
			<h6 class="m-0">Δεν υπάρχει καμία παραγγελία.</h6>
		</li>
		<li v-else v-for="(order, index) in orders" :key="index" class='list-group-item mt-2 mb-4 border-0'>
			<div class='row'>
				<div class='col-xl-3 col-lg-3 col-md-3 col-6 text-xl-left text-lg-left text-left my-auto'>
					<h6>{{ order.id }}</h6>
				</div>
				<div class='col-xl-3 col-lg-3 col-md-3 col-6 text-xl-left text-lg-left text-right my-auto'>
					<h6>{{ formatDate(order.date) }}</h6>
					<p>{{ order.time }}</p>
				</div>
				<div class='col-xl-3 col-lg-3 col-md-3 col-12 my-auto'>
					<div v-for="(coffee, index) in coffeesOrder(order)" :key="index" class='row m-xl-0 m-lg-0 m-md-0 mx-1'>
						<h6 class='mr-2'>{{ coffee[index, 1] }}x</h6>
						<h6>{{ coffee[index, 0] }}</h6>
					</div>
				</div>
				<div class='col-xl-1 col-lg-1 col-md-1 col-12 cost my-auto'>
					<h6>{{ fullPrice(order.price) }}€</h6>
				</div>
				<div class="col-xl-2 col-lg-2 col-md-2 col-12 my-auto">
					<button v-on:click="orderAgain(order.id)" type="button" class="btn mainbtn btn-block text-white orderAgain">Παράγγειλε ξανά</button>
				</div>
			</div>
		</li>
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Orders',
	data() {
		return {
			hasErrorMessage: '',
			hasNoOrders: true,
			coffees: [],
			orders: []
		}
	},

	async created() {
		try {
			const token = VueCookies.get('token');

			let response = await fetch('http://localhost:3000/home/orders', {
				method: 'GET',
				headers: {
					"Authorization" : token,
				}
			});

			if (response.ok) {
				let res = await response.json();

				if (res.hasOrders) {
					this.hasNoOrders = false;
					this.orders = res.orders;
				}
				else if (!res.hasOrders) {
					this.hasNoOrders = true;
				}
			}
			else if (!response.ok) {
				this.$notify({
					group: 'errors',
					type: 'success',
					title: 'Ειδοποίηση',
					text: response.status
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
	
	},

	methods: {
		formatDate: function(date) {
			return date.slice(8, 10) + '/' + date.slice(5, 7) + '/' + date.slice(0, 4);
		},

		fullPrice: function(order_price) {
			return order_price.split(',').reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);
		},

		coffeesOrder: function(order) {
			let coffees = order.coffees.split(',');
			let quantities = order.qty.split(',');
			return coffees.map((coffee, i) => [coffee, quantities[i]]);
		},

		orderAgain: async function(id) {
			try {
				const token = VueCookies.get('token');

				let res = await fetch('http://localhost:3000/order/reorder', {
					method: 'POST',
					body: JSON.stringify({
						id
					}),
					headers: {
						"Authorization" : token,
						"Content-type" : "application/json; charset=UTF-8"
					}
				});

				if (res.ok) {
					let resolve = await res.json();

					if (resolve.status) {
						console.log(resolve.status);
					}
					else if (resolve.error){
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: resolve.error
						});
					}
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
		}
	},
}
</script>

<style>

</style>