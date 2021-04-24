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
							<div class="col-xl-3 col-6">
								<h6>Περιοχή</h6>
							</div>
						</div>
					</li>
					<li v-if="addresses.length === 0" class='list-group-item m-0 border-0'>
						<h6>Δεν υπάρχει ενεργή διεύθυνση</h6>
					</li>
					<div v-else v-for="(address, index) in addresses" :key="index" class="d-flex justify-content-center w-100">
						<li class='w-100 list-group-item m-0 border-0'>
							<div class='row d-flex justify-content-start align-items-center'>
								<div class='col-xl-3 col-6'>
									<h6 class='m-0'>{{ address.address }}</h6>
								</div>
								<div class='col-xl-3 col-6'>
									<h6 class='m-0'>{{ address.state }}</h6>
								</div>
								<div class='col-xl-2 col-12'>
									<button v-on:click="deleteAddress(address.address)" class='btn btn-block btn-danger mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3' role='button'>Διαγραφή</button>
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
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Addresses',
	data() {
		return {
			addresses: []
		}
	},

	created() {
		this.fetchAddress();	
	},

	methods: {
		deleteAddress: async function(address) {
			NProgress.start();
			try {
				const token = VueCookies.get('token');

				let response = await fetch('http://localhost:3000/home/delete', {
					method: 'POST',
					body: JSON.stringify({
						address
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
							text: 'Η διεύθυνση διαγράφηκε με επιτυχία.'
						});
						this.fetchAddress();
					}
					else if (res.status){
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Cofy',
							text: res.status
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

		fetchAddress: async function() {
			try {
				const token = VueCookies.get('token');

				let response = await fetch('http://localhost:3000/home/addresses' , {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});

				if (response.ok) {
					let res = await response.json();

					if (res.hasAddress) {
						this.addresses = res.addresses;
					}
					else if (!res.hasAddress) {
						this.addresses = [];
					}
				}
				else if (!response.ok) {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: response.status
					});
				}
			}
			catch (error) {
				this.$notify({
					group: 'errors',
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