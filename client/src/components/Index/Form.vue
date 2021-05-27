<template>
	<div class="login-snip text-white">
		<div class="d-grid justify-content-start">
			<h2>Σύνδεση</h2>
		</div>
		<div class="login-space">
			<div class="login pl-0">
				<form v-on:submit.prevent="SignIn" novalidate>
					<div class="group py-2">
						<label class="label">Email</label>
						<input v-model.trim="$v.email.$model" :class="{ 'error' : $v.email.$error }" type="email" class="input form-control border-0" placeholder="Γράψε τη Διεύθυνση Email" required>
						<div v-if="!$v.email.required && $v.email.$dirty" class="text-danger">Πρέπει να συμπληρώσεις το email σου.</div>
					</div>
					<div class="group py-2">
						<label class="label">Password</label>
						<input v-model.trim="$v.password.$model" :class="{ 'error' : $v.password.$error}" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
						<div v-if="!$v.password.required && $v.password.$dirty" class="text-danger">Πρέπει να συμπληρώσεις τον κωδικό σου.</div>
					</div>
					<div class="group py-2">
						<div class="form-check pointer-base">
							<input type="checkbox" class="form-check-input" id="rememberme" v-model="RememberMe">
							<label class="custom-control-label pointer-base ms-1" for="rememberme">Να με θυμάσαι</label>
						</div>
					</div>
					<div class="group d-grid py-2">
						<button type="submit" class="btn mainbtn">Σύνδεση</button>
						<div class="d-flex justify-content-center" :class="{ 'my-3': isLoading }">
							<div v-if="isLoading" class="spinner-border text-light" role="status"></div>
							<p v-if="hasErrorMsg" class='text-center text-danger mt-1 mb-0'>{{ hasErrorMsg }}</p>
						</div>
					</div>
				</form>
				<h2 class="d-flex justify-content-center mb-2">ή</h2>
				<div class="group d-grid">
					<router-link to="/register" type="button" class="btn mainbtn">Εγγραφή</router-link>
				</div>
				<hr class="my-4"/>
				<div class="text-center"> 
					<router-link to="/reset">Ξέχασες τον κωδικό σου?</router-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';
import router from '../../router';
import { required } from 'vuelidate/lib/validators';

export default {
	name: "Form",

	validations: {
		email: {
			required,
		},
		password: {
			required,
		},
	},

	data() {
		return {
			email: '',
			password: '',
			hasErrorMsg: '',
			isLoading: false,
			RememberMe: false
		}
	},

	mounted() {
		document.addEventListener('visibilitychange', this.visibilityChange);
	},

	methods: {
		visibilityChange: function() {
			this.$v.email.$reset();
			this.$v.password.$reset();
		},

		SignIn: async function() {
			this.$v.$touch();

			if(!this.$v.$invalid){
				this.isLoading = true;
				this.hasErrorMsg = '';

				try {
					let response = await fetch('http://localhost:3000/auth/login', {
						method: 'POST',
						body: JSON.stringify({
							email: this.email,
							password: this.password,
							rememberme: this.RememberMe
						}),
						headers: {
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (response.ok) {
						let resolve = await response.json();

						if (resolve.auth === true) {
							this.$store.state.token = resolve.token;
							this.$cookies.set("token" , resolve.token , "2h");
							const token = VueCookies.get('token');
							this.FetchUserInfo(token);
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
		},

		FetchUserInfo: async function(token) {
			try {
				let res = await fetch('http://localhost:3000/auth/user', {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});

				if (res.ok) {
					let resolve = await res.json();

					if (!resolve.error) {
						this.$store.state.userInfo.email = resolve.email;
						this.$store.state.userInfo.name = resolve.name;
						this.$store.state.userInfo.surname = resolve.surname;
						this.$store.state.userInfo.mobile = resolve.mobile;
					}
					else {
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: resolve.error
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
		}
	},
}
</script>

<style scoped>
@media screen and (min-width: 280px) and (max-width: 400px) {
	.login-snip {
		min-width: 200px !important;
		padding: 20px 20px 20px 20px !important;
	}

	.login-snip {
		border-radius: 0 !important;
	}
}

@media screen and (min-width: 400px) and (max-width: 850px) {
	.login-snip {
		padding: 30px 40px 10px 40px !important;
	}
	.login-snip {
		border-radius: 0 !important;
	}
}

.hr {
    height: 2px;
    background: rgba(255, 255, 255, 0.39)
}

.login-snip {
	width: 100%;
	max-width: 400px;
	min-width: 400px;
	min-height: 600px;
	border-radius: 23px;
	padding: 40px;
	background: #301504ea;
}

.login-space {
	perspective: 1000px;
	transform-style: preserve-3d;
}

.login-space .group .label,
.login-space .group .input,
.login-space .group .button {
	color: #fff !important;
	display: block;
}

.login-space .group .input {
	background: #c2c2c21c;
}
</style>