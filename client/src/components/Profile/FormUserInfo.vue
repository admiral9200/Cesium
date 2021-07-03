<template>
	<form v-on:submit.prevent="changeUserInfo()">
		<div class="form-group row mb-0">
			<div class="col-xl-5 col-12">
				<label class="col-xl-5 col-form-label form-control-label pl-0">Όνομα</label>
				<input v-model.trim="$v.name.$model" :class="{ 'error' : $v.name.$error }" class="form-control"/>
				<div v-if="!$v.name.required && $v.name.$dirty" class="text-danger">Πρέπει να συμπληρώσεις ένα όνομα</div>
			</div>
			<div class="col-xl-5 col-12">
				<label class="col-xl-5 col-form-label form-control-label pl-0" autocomplete="off">Επώνυμο</label>
				<input v-model.trim="$v.surname.$model" :class="{ 'error' : $v.surname.$error}" class="form-control" type="text"/>
				<div v-if="!$v.surname.required && $v.surname.$dirty" class="text-danger">Πρέπει να συμπληρώσεις ένα επίθετο</div>
			</div>
		</div>
		<div class="form-group row mt-4 mb-0">
			<label class="col-xl-5 col-form-label form-control-label pl-3">Email</label>
		</div>
		<div class="form-group row">
			<div class="col-xl-5 mb-0">
				<input :value="Email" class="form-control" type="email" disabled/>
			</div>
		</div>
		<div class="form-group row mt-4 mb-0">
			<label class="col-5 col-form-label form-control-label pl-3">Κινητό</label>
		</div>
		<div class="form-group row">
			<div class="col-5 mb-0">
				<input v-model.trim="$v.mobile.$model" class="form-control" :class="{ 'error' : $v.mobile.$error}" type="text"/>
				<div v-if="!$v.mobile.numeric && $v.mobile.$dirty" class="text-danger">Πρέπει να συμπληρώσεις το κινητό σου σωστά</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-12 mt-4 text-left">
				<button type="submit" class="btn btn-block mainbtn">Αποθήκευση Αλλαγών</button>
			</div>
		</div>
	</form>
</template>

<script>
import store from '../../store/store';
import NProgress from 'nprogress';
import { required, numeric } from 'vuelidate/lib/validators';

export default {
	name: 'FormUserInfo',

	data() {
		return {
			name: '',
			surname: '',
			mobile: ''
		}
	},

	validations: {
		name: {
			required,
		},

		surname: {
			required,
		},

		mobile: {
			numeric
		}
	},

	computed: {
		Email() {
			return this.$store.state.userInfo.email;
		}
	},

	async created() {
		const token = this.$cookies.get('token');

		if (token !== null) {
			fetch('http://localhost:3000/user/info', {
				method: 'GET',
				headers: {
					"Authorization" : token,
				}
			})
			.then(res => res.json())
			.then(resolve => {
				if (!resolve.error) {
					this.name = resolve.name;
					this.surname = resolve.surname;
					this.mobile = resolve.mobile;
				}
				else {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: resolve.error
					});
				}
			})
			.catch(error => {
				this.$notify({
					group: 'errors',
					type: 'error',
					title: 'Error',
					text: error
				});
			})
			.finally(() => NProgress.done());
		}
	},

	methods: {
		changeUserInfo: async function() {
			const token = this.$cookies.get('token');
			this.$v.$touch();

			if (!this.$v.$invalid && token) {
				NProgress.start();
				try {	
					let response = await fetch('http://localhost:3000/profile/info', {
						method: 'POST',
						body: JSON.stringify({
							name: this.name,
							surname: this.surname,
						}),
						headers: {
							"Content-type" : "application/json; charset=UTF-8",
							"Authorization" : token,
						}
					});

					if (response.ok) {
						let res = await response.json();

						if (res.completed) {
							await store.dispatch('fetchUserInfo');
							
							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Cofy',
								text: 'Τα στοιχεία σου άλλαξαν με επιτυχία'
							});
							
							NProgress.done();
						}
					}
					else {
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
						type: 'error',
						title: 'Error',
						text: error
					});
				}
				finally {
					NProgress.done();
				}
			}
		},

		// TODO Create user password change and account deletion
	}
}
</script>