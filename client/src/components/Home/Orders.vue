<template>
	<div>
		<div v-if="hasErrorMessage" class="col-12 px-xl-2 px-0">
			<div class='alert alert-danger alert-dismissible fade show'>
				<button type='button' class='close' data-dismiss='alert'>&times;</button>{{ hasErrorMessage }}
			</div>
		</div>
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
						<h6 class='mr-2'>{{ index }}x</h6>
						<h6>{{ coffee }}</h6>
					</div>
				</div>
				<div class='col-xl-1 col-lg-1 col-md-1 col-12 cost my-auto'>
					<h6>2.53€</h6>
				</div>
				<div class="col-xl-2 col-lg-2 col-md-2 col-12 my-auto">
					<button type="button" class="btn mainbtn btn-block text-white orderAgain">Παράγγειλε ξανά</button>
				</div>
			</div>
		</li>
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';

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

	computed: {
		
	},

	async created() {
		try {
			let token = VueCookies.get('token');

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
				this.hasErrorMessage = response.status;
			}
		}
		catch (error) {
			this.hasErrorMessage = error;
		}
	},

	methods: {
		formatDate: function(date) {
			return date.slice(8, 10) + '/' + date.slice(5, 7) + '/' + date.slice(0, 4);
		},

		coffeesOrder: function(order) {
			let coffees = order.coffees.split(',');
			let quantities = order.qty.split(',');
			let prices = order.price.split(',');
			return { coffees, quantities, prices };
		}
	},
}
</script>

<style>

</style>