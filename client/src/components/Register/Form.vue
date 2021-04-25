<template>
	<div>
		<div class="signup-space">
			<form v-on:submit.prevent="SignUp" novalidate>
				<div class="row">
					<div class="col">
						<div class="group py-2">
							<label class="label">Email</label>
							<input v-model.trim="$v.email.$model" :class="{ 'error' : $v.email.$error }" type="email" class="input form-control border-0" placeholder="Γράψε τη Διέυθυνση Email" required>
							<div v-if="!$v.email.required && $v.email.$dirty" class="text-danger">Πρέπει να συμπληρώσεις το email σου.</div>
							<div v-if="!$v.email.email && $v.email.$dirty" class="text-danger">Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.</div>
						</div>
						<div class="group py-2">
							<label class="label">Όνομα</label> 
							<input v-model.trim="$v.name.$model" :class="{ 'error' : $v.name.$error }" type="text" class="input form-control border-0" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
							<div v-if="!$v.name.required && $v.name.$dirty" class="text-danger">Πρέπει να συμπληρώσεις το όνομα σου</div>
							<div v-if="!$v.name.alpha && $v.name.$dirty" class="text-danger">Το όνομα πρέπει να περιέχει μόνο γράμματα</div>
						</div>
						<div class="group py-2">
							<label class="label">Επίθετο</label> 
							<input v-model.trim="$v.surname.$model" :class="{ 'error' : $v.surname.$error }" type="text" class="input form-control border-0" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
							<div v-if="!$v.surname.required && $v.surname.$dirty" class="text-danger">Πρέπει να συμπληρώσεις το επίθετο σου.</div>
							<div v-if="!$v.surname.alpha && $v.surname.$dirty" class="text-danger">Το επίθετο πρέπει να περιέχει μόνο γράμματα</div>
						</div>
						<div class="group py-2">
							<label class="label">Κωδικός</label> 
							<input v-model.trim="$v.password.$model" :class="{ 'error' : $v.password.$error }" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
							<div v-if="!$v.password.required && $v.password.$dirty" class="text-danger">Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης</div>
							<div v-if="!$v.password.minLength && $v.password.$dirty" class="text-danger">Ο κωδικός πρόσβασης πρέπει να έιναι μεγαλύτερος από 9 χαρακτήρες</div>
						</div>
						<div class="group py-2">
							<label class="label">Επαλήθευση Κωδικού</label> 
							<input v-model.trim="$v.passwordConfirm.$model" :class="{ 'error' : $v.passwordConfirm.$error }" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε ξανά τον κωδικό σου" required>
							<div v-if="!$v.passwordConfirm.required && $v.passwordConfirm.$dirty" class="text-danger">Πρέπει να συμπληρώσεις ξανά τον κωδικό πρόσβασης.</div>
							<div v-if="$v.passwordConfirm.required && !$v.passwordConfirm.sameAsPassword && $v.passwordConfirm.$dirty" class="text-danger">Ο κωδικός δεν είναι ίδιος με τον προηγούμενο.</div>
						</div>
						<div class="group py-2">
							<div class="form-check pointer-base">
								<input @change="$v.terms.$touch()" v-model="terms" type="checkbox" class="form-check-input" id="termsAccept" required>
								<label class="custom-control-label pointer-base ms-1" for="termsAccept">Αποδέχομαι τους όρους χρήσης</label>
								<div v-if="!$v.terms.sameAs && $v.terms.$dirty" class="text-danger">Πρέπει να αποδεχτείς τους όρους χρήσης.</div>
							</div>
						</div>
						<div class="d-grid mt-4 py-2">
							<button type="submit" class="btn btn-block text-white mainbtn">Εγγραφή</button>
						</div> 
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import NProgress from 'nprogress';
import { required, minLength, email, alpha, sameAs } from 'vuelidate/lib/validators';

export default {
	name: 'Form',

	props: ['signupCompleted'],

	validations: {
		email: {
			required,
			email
		},
		name: {
			required,
			alpha
		},
		surname: {
			required,
			alpha
		},
		password: {
			required,
			minLength: minLength(9)
		},
		passwordConfirm: {
			required,
			sameAsPassword: sameAs('password')
		},
		terms: {
			sameAs: sameAs(() => true),
		}
	},

	data() {
		return {
			email: '',
			password: '',
			passwordConfirm: '',
			name: '',
			surname: '',
			terms: false,
			termsButtonNotChecked: false,
			hasErrorMsg: '',
		}
	},

	mounted() {
		document.addEventListener('visibilitychange', this.visibilityChange);
	},

	methods: {
		visibilityChange: function() {
			this.$v.email.$reset();
			this.$v.name.$reset();
			this.$v.surname.$reset();
			this.$v.password.$reset();
			this.$v.passwordConfirm.$reset();
		},

		SignUp: async function() {
			NProgress.start();
			this.$v.$touch();

			if(!this.$v.$invalid){
				this.hasErrorMsg = '';

				try {
					const response = await fetch('http://localhost:3000/auth/register', {
						method: 'POST',
						body: JSON.stringify({
							email: this.email,
							password: this.password,
							passwordConfirm: this.passwordConfirm,
							name: this.name,
							surname: this.surname,
							termsAccept: this.terms
						}),
						headers: {
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (response.ok) {
						let resolve = await response.json();

						if (resolve.status === "ok") {
							this.$emit("SignUpSuccessful", true);
						}
						else if (resolve.errors) {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Cofy',
								text: resolve.errors[0].msg
							});
							
						}
						else if (resolve.error){
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Cofy',
								text: resolve.error
							});
						}
					}
					else if (!response.ok) {
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Cofy',
							text: response.status
						});
					}
				}
				catch (error) {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Cofy',
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

<style scoped>
.signup-space {
	perspective: 1000px;
	transform-style: preserve-3d;
}

.signup-space .group .label,
.signup-space .group .input,
.signup-space .group .button {
	color: #fff !important;
	display: block;
}

.signup-space .group .input {
	background: #c2c2c21c;
}

/* Animation Loader */
.lds-dual-ring {
  margin-bottom: 5px;
  margin-top: 5px;
}

.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 30px;
  height: 30px;
  margin: 0;
  border-radius: 50%;
  border: 6px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}

@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
/* Animation Loader */
</style>