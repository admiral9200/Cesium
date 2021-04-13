<template>
	<div class="col">
		<div v-if="hasErrorMessage" class="m-3">
			<div class='alert alert-danger alert-dismissible fade show'>
				<button type='button' class='close' data-dismiss='alert'>&times;</button>{{ hasErrorMessage }}
			</div>
		</div>
		<form v-on:submit.prevent="addAddress" class="row w-100 mx-auto">
			<div class="group col-xl-5 col-12 mt-2 m-xl-0">   
				<input v-model="address" v-on:input="CheckAddress" :class="{ 'wrong' : isAddressEmpty === true}" type="text" class="input form-control w-100" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου">
				<div v-if="isAddressEmpty" class="text-danger">Πρέπει να συμπληρώσεις την διεύθυνσή σου.</div>
			</div>
			<div class="group col-xl-5 col-12 mt-2 m-xl-0">
				<input v-model="state" v-on:input="CheckState" :class="{ 'wrong' : isStateEmpty === true}" type="text" class="input form-control w-100" placeholder="Πρόσθεσε εδώ την περιοχή σου">
				<div v-if="isStateEmpty" class="text-danger">Πρέπει να συμπληρώσεις την περιοχή σου.</div>
			</div>
			<div class="group col-xl-2 col-12 mt-2 m-xl-0">
				<button type="submit" class="btn btn-block mainbtn">Προσθήκη</button>
			</div>
		</form>
	</div>
</template>

<script>
import NProgress from 'nprogress';
import VueCookies from 'vue-cookies';

export default {
	name: "InsertAddress",
	data() {
		return {
			address: '',
			state: '',
			isAddressEmpty: false,
			isStateEmpty: false,
			hasErrorMessage: false,
		}
	},

	mounted() {
		document.addEventListener('visibilitychange', this.visibilityChange);
	},

	methods: {
		visibilityChange: function() {
			this.isAddressEmpty = false;
			this.isStateEmpty = false;
		},

		CheckAddress: function() {
			this.isAddressEmpty = false;
			if (this.address === '') {
				this.isAddressEmpty = true;
			}
		},

		CheckState: function() {
			this.isStateEmpty = false;
			if (this.state === '') {
				this.isStateEmpty = true;
			}
		},

		ValidateForm: function() {
			let val = true;
			if (this.address === '') {
				this.isAddressEmpty = true;
				val = false;
			}
			if (this.state === '') {
				this.isStateEmpty = true;
				val = false;
			}
			return val;
		},

		addAddress: async function() {
			if (this.ValidateForm()) {
				try {
					this.hasErrorMessage = '';
					NProgress.start();

					let user = VueCookies.get('user');
					let token = VueCookies.get('token');

					let response = await fetch('http://localhost:3000/home/insert', {
						method: 'POST',
						body: JSON.stringify({
							user,
							address: this.address,
							state: this.state
						}),
						headers: {
							"Authorization" : token,
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (response.ok) {
						let res = await response.json();

						if (res.status === "OK") {
							this.hasErrorMessage = '';
						}
						else {
							this.hasErrorMessage = res.status;
						}

						if (res.error) {
							this.hasErrorMessage = res.error;
						}
					}
				} 
				catch (error) {
					this.hasErrorMessage = error;
				}
				finally {
					NProgress.done();
				}
			}
		}
	},
}
</script>

<style>

</style>