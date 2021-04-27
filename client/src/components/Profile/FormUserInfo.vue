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
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';
import { required, numeric } from 'vuelidate/lib/validators';

export default {
	name: 'FormUserInfo',

	data() {
		return {
			name: '',
			surname: '',
			mobile: '',
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

	watch: {
		Name: function() {
			console.log("WATCH RUN")
			this.name = this.Name;
		},

		Surname: function() {
			this.surname = this.Surname;
		},

		Mobile: function() {
			this.mobile = this.Mobile;
		}
	},

	computed: {
		Name() {
			return this.$store.state.userInfo.name;
		},

		Surname() {
			return this.$store.state.userInfo.surname;
		},

		Email() {
			return this.$store.state.userInfo.email;
		},

		Mobile(){
			return this.$store.state.userInfo.mobile;
		}
	},

	methods: {
		changeUserInfo: async function() {
			NProgress.start();
			const token = VueCookies.get('token');
			this.$v.$touch();

			if (!this.$v.$invalid) {
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
							this.$store.state.userInfo.name = this.name;
							this.$store.state.userInfo.surname = this.surname;
							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Cofy',
								text: 'Τα στοιχεία σου άλλαξαν με επιτυχία'
							});
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
	},
}
</script>

<style>

</style>