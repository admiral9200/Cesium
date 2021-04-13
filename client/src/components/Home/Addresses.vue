<template>
	<div>
		<div v-if="hasErrorMessage" class="col-12 px-xl-2 px-0">
			<div class='alert alert-danger alert-dismissible fade show'>
				<button type='button' class='close' data-dismiss='alert'>&times;</button>{{ hasErrorMessage }}
			</div>
		</div>
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
					<li v-if="hasNoAddress" class='list-group-item m-0 border-0'>
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
									<button class='btn btn-block btn-danger mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3' role='button'>Διαγραφή</button>
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

export default {
	name: 'Addresses',
	data() {
		return {
			addresses: [],
			hasNoAddress: true,
			hasErrorMessage: ''
		}
	},
	async created() {
		try {
			this.hasErrorMessage = '';
			let token = VueCookies.get('token');

			let response = await fetch('http://localhost:3000/home/addresses' , {
				method: 'GET',
				headers: {
					"Authorization" : token,
				}
			});

			if (response.ok) {
				let res = await response.json();

				if (res.hasAddress) {
					this.hasNoAddress = false;
					this.addresses = res.addresses;
				}
				else if (!res.hasAddress) {
					this.hasNoAddress = true;
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
		
	},
}
</script>

<style>

</style>