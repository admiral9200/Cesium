<template>
	<div>
		<div class="row">
			<div class="col-12">
				<ul class="list-group list-group-flush">
					<li class="list-group-item mt-4 mb-4">
						<div class="row">
							<div class="col-xl-3 col-6">
								<h6>Διεύθυνση</h6>
							</div>
						</div>
					</li>
					<li v-if="UserAddresses.length === 0" class='list-group-item m-0 border-0'>
						<h6>Δεν υπάρχει ενεργή διεύθυνση</h6>
					</li>
					<div v-else v-for="(address, index) in UserAddresses" :key="index" class="d-flex justify-content-center w-100">
						<li class='w-100 list-group-item m-0 border-0'>
							<div class='row d-flex justify-content-start align-items-center'>
								<div class='col-xl-5 col-6'>
									<h6 class='m-0'>{{ address.route }} {{ address.street_number }}, {{ address.locality }} {{ address.postal_code }}</h6>
								</div>
								<div class='col-xl-5 col-12'>
									<button v-on:click="MakeAddressActive()" class='btn btn-sm btn-outline-success mx-3 mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3' role='button'>Ενεργή</button>
									<button v-on:click="deleteAddress(address._id)" class='btn btn-sm btn-danger mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3' role='button'>Διαγραφή</button>
								</div>
							</div>
						</li>
					</div>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
import store from '../../store/store';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Addresses',
	
	data() {
		return {
			addresses: []
		}
	},

	computed: {
		UserAddresses() {
			return this.$store.state.userAddresses;
		}
	},

	mounted() {
		this.$root.$on('fetchAdresses', async () => {
			await store.dispatch('fetchUserAddresses')
			NProgress.done();
		});
	},

	methods: {
		deleteAddress: async function(address_id) {
			NProgress.start();
			try {
				const token = VueCookies.get('token');

				let response = await fetch('http://localhost:3000/home/delete', {
					method: 'POST',
					body: JSON.stringify({
						id: address_id
					}),
					headers: {
						"Authorization" : token,
						"Content-type" : "application/json; charset=UTF-8"
					}	
				});

				if (response.ok) {
					let res = await response.json();

					if (res.deleted === true) {
						this.$notify({
							group: 'errors',
							type: 'success',
							title: 'Cofy',
							text: res.msg
						});
						await store.dispatch('fetchUserAddresses');
					}
					else if (res.error){
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Cofy',
							text: res.error
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
			finally {
				NProgress.done();
			}
		},
	},
}
</script>

<style>

</style>