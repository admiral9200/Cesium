<template>
	<v-form v-on:submit.prevent="Login" class="cc_form">
		<v-row>
			<v-col cols="12">
				<v-text-field 
					v-model="username"
					:error-messages="usernameErrors"
					label="Username"
					@input="$v.username.$touch()"
					@blur="$v.username.$touch()"
					required
				></v-text-field>
				<v-text-field
					v-model="password"
					:error-messages="passwordErrors"
					:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
					:type="showPassword ? 'text' : 'password'"
					name="input-10-1"
					label="Password"
					counter
					@input="$v.password.$touch()"
					@blur="$v.password.$touch()"
					@click:append="showPassword = !showPassword"
				></v-text-field>
				<v-btn block color="amber" class="mt-8 black--text" @click="Login">Login</v-btn>
				<div class="text-center my-3">
					<v-progress-circular indeterminate color="amber" v-if="isLoading"></v-progress-circular>
					<p v-if="hasErrorMsg" class='red--text'>{{ hasErrorMsg }}</p>
				</div>
			</v-col>
		</v-row>
	</v-form>
</template>

<script>
import router from '@/router/index';
import { required } from 'vuelidate/lib/validators';
import store from '@/store/index';

export default {
	data () {
		return {
			showPassword: false,
			username: '',
			password: '',
			isLoading: false,
			hasErrorMsg: ''
		}
    },

	validations: {
		username: {
			required,
		},
		password: {
			required,
		},
	},

	computed: {
		usernameErrors() {
			const errors = [];
			if (!this.$v.username.$dirty) return errors;
			!this.$v.username.required && errors.push('Username is required.');
			return errors;
		},

		passwordErrors() {
			const errors = [];
			if (!this.$v.password.$dirty) return errors;
			!this.$v.password.required && errors.push('Password is required.');
			return errors;
		}
	},

	methods: {
		Login: async function() {
			this.$v.$touch();

			if(!this.$v.$invalid){
				this.isLoading = true;
				this.hasErrorMsg = '';

				try {
					let response = await fetch('http://' + this.$store.state.base_url + ':3000/m/auth/login', {
						method: 'POST',
						body: JSON.stringify({
							username: this.username,
							password: this.password,
						}),
						headers: {
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (response.ok) {
						let resolve = await response.json();

						if (resolve.auth === true) {
							this.$cookies.set("cc_b_id" , resolve.token , "5h");
							await store.dispatch('fetchUserInfo');
							router.push("/home");
						}
						else if (resolve.error) {
							this.isLoading = false;
							this.hasErrorMsg = resolve.error;
						}
					}
					else if (!response.ok) {
						this.isLoading = false;
						this.hasErrorMsg = response.status;
					}
				}
				catch (error) {
					this.isLoading = false;
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Cofy',
						text: error
					});
				}
			}
		}
	},
}
</script>

<style>
.cc_form{
	min-width: 500px;
}
</style>