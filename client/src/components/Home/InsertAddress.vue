<template>
	<div class="col justify-content-center">
		<form v-on:submit.prevent="addAddress" class="row justify-content-center">
			<div class="group col-xl-5 col-12 pr-0">   
				<input v-model.trim="$v.address.$model" :class="{ 'wrong': $v.address.$error }" type="text" class="input form-control border-right-0" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου">
				<div v-if="$v.address.$error" class="text-danger">Πρέπει να συμπληρώσεις την διεύθυνσή σου.</div>
			</div>
			<div class="group col-xl-2 col-12 pl-0">
				<button type="submit" class="btn btn-block mainbtn">Προσθήκη</button>
			</div>
		</form>
	</div>
</template>

<script>
import NProgress from 'nprogress';
import VueCookies from 'vue-cookies';
import { required } from 'vuelidate/lib/validators';

export default {
	name: "InsertAddress",
	data() {
		return {
			address: ''
		}
	},

	validations: {
		address: {
			required
		}
	},

	mounted() {
		document.addEventListener('visibilitychange', this.visibilityChange);
	},

	methods: {
		visibilityChange: function() {
			this.$v.address.$reset;
		},

		addAddress: async function() {
			//TODO: Use google maps for searching legitimate addresses to insert
			NProgress.start();
			this.$v.address.$touch();

			if (!this.$v.address.$invalid) {
				try {
					const token = VueCookies.get('token');

					let response = await fetch('http://localhost:3000/home/insert', {
						method: 'POST',
						body: JSON.stringify({
							address: this.address
						}),
						headers: {
							"Authorization" : token,
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (response.ok) {
						let res = await response.json();

						if (res.status === "OK") {
							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Ειδοποίηση',
								text: 'Η διεύθυνση προστέθηκε.'
							});
						}
						else if (res.error) {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: res.error
							});
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: 'An unexpected error occured'
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
			}
		}
	},
}
</script>

<style>

</style>