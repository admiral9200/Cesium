<template>
	<div class="container my-3">
		<form v-on:submit.prevent="addAddress" class="d-flex justify-content-center">
			<div class="input-group w-50">
				<input v-model.trim="$v.address.$model" :class="{ 'wrong': $v.address.$error }" type="text" class="form-control form-control-lg" placeholder="Πρόσθεσε εδώ την διεύθυνσή σου" aria-describedby="insert">
				<button class="btn mainbtn" type="submit" id="insert">Προσθήκη</button>
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
			this.$v.address.$reset();
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

						if (res.completed === true) {
							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Ειδοποίηση',
								text: 'Η διεύθυνση προστέθηκε.'
							});
							this.$root.$emit('fetchAdresses');
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