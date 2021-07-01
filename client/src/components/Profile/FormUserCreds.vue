<template>
	<form v-on:submit.prevent="changeUserCreds">
		<div class="form-group row mt-4 mb-0">
			<label class="col-xl-5 col-12 col-form-label form-control-label pl-3">Τρέχων κωδικός</label>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" v-model.trim="$v.oldPassword.$model" :class="{ 'error': $v.oldPassword.$error }"/>
			<div class="text-danger" v-if="$v.oldPassword.$error">Πρέπει να συμπληρώσεις τον τωρινό κωδικό</div>
		</div>
		<div class="form-group row mt-4 mb-0">
			<label class="col-xl-5 col-12 col-form-label form-control-label">Νέος κωδικός</label>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" v-model.trim="$v.newPassword.$model" :class="{ 'error': $v.newPassword.$error }"/>
			<div class="text-danger" v-if="!$v.newPassword.required && $v.newPassword.$dirty">Πρέπει να συμπληρώσεις τον καινούριο κωδικό</div>
			<div class="text-danger" v-if="!$v.newPassword.minLength && $v.newPassword.$dirty">Ο κωδικός πρέπει να είναι μεγαλύτερος απο 9 χαρακτήρες</div>
		</div>
		<div class="form-group row mt-4">
			<div class="col-xl-12 col-12">
				<button type="submit" class="btn mainbtn">Αποθήκευση Αλλαγών</button>
			</div>
		</div>
	</form>
</template>

<script>
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';
import { required, minLength } from 'vuelidate/lib/validators';

export default {
	name: "FormUserCreds",

	data() {
		return {
			oldPassword: '',
			newPassword: ''
		}
	},

	validations: {
		oldPassword: {
			required,
		},
		newPassword: {
			required,
			minLength: minLength(9)
		},
	},

	mounted() {
		document.addEventListener('visibilitychange', this.visibilityChange);
	},

	methods: {
		visibilityChange: function() {
			this.$v.oldPassword.$reset();
			this.$v.newPassword.$reset();
		},

		changeUserCreds: async function() {
			const token = VueCookies.get('token');
			this.$v.oldPassword.$touch();
			this.$v.newPassword.$touch();

			if (!this.$v.oldPassword.$invalid && !this.$v.newPassword.$invalid && token) {
				NProgress.start();
				
				const oldpass = this.oldPassword;
				const newpass = this.newPassword;
				try {
					let response = await fetch('http://localhost:3000/profile/credentials', {
						method: 'POST',
						body: JSON.stringify({
							oldpass,
							newpass
						}),
						headers: {
							"Content-type" : "application/json; charset=UTF-8",
							"Authorization" : token,
						}
					});

					if (response.ok) {
						const res = await response.json();

						if (res.completed) {
							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Cofy',
								text: res.msg
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
						else if (res.errors) {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: res.error.msg
							});
						}
					}
					else {
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: response.statusText
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
			}
		}
	},
}
</script>

<style>

</style>