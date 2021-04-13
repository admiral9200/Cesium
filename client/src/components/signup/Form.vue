<template>
	<div>
		<div class="signup-space">
			<form v-on:submit.prevent="SignUp" novalidate>
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="group py-2">
							<label class="label">Email</label>
							<input v-on:input="CheckEmail" :class="{ 'wrong' : isEmailEmpty === true}" v-model="email" type="email" class="input form-control border-0" placeholder="Γράψε τη Διέυθυνση Email" required>
							<div v-if="isEmailEmpty" class="warn-info">{{ warnMsg }}</div>
						</div>
						<div class="group py-2">
							<label class="label">Όνομα</label> 
							<input v-on:input="CheckNameValue" :class="{ 'wrong' : isNameEmpty === true}" v-model="name" type="text" class="input form-control border-0" data-type="firstName" placeholder="Γράψε το Όνομα σου" required>
							<div v-if="isNameEmpty" class="warn-info">Πρέπει να συμπληρώσεις το όνομα σου</div>
						</div>
						<div class="group py-2">
							<label class="label">Επίθετο</label> 
							<input v-on:input="CheckSurnameValue" :class="{ 'wrong' : isSurnameEmpty === true}" v-model="surname" type="text" class="input form-control border-0" data-type="lastName" placeholder="Γράψε το Επίθετο σου" required>
							<div v-if="isSurnameEmpty" class="warn-info">Πρέπει να συμπληρώσεις το επίθετο σου.</div>
						</div>                                           
						<div class="group py-2">
							<label class="label">Κινητό Τηλέφωνο</label> 
							<input v-on:input="CheckMobileValue" :class="{ 'wrong' : isMobileEmpty === true}" v-model="mobile" type="tel" class="input form-control border-0" data-type="mobile" placeholder="Γράψε το κινητό σου" pattern="[0-9]{10}" required>
							<div v-if="isMobileEmpty" class="warn-info">Πρέπει να συμπληρώσεις το κινητό σου.</div>
						</div>                                           
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="group py-2">
							<label class="label">Κωδικός</label> 
							<input v-on:input="CheckPassValue" :class="{ 'wrong' : isPasswordEmpty === true}" v-model="password" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε τον κωδικό σου" required>
							<div v-if="isPasswordEmpty" class="warn-info">{{ passwordMessage }}</div>
						</div>
						<div class="group py-2">
							<label class="label">Επαλήθευση Κωδικού</label> 
							<input v-on:input="CheckPassConfirmValue" :class="{ 'wrong' : passwordConfirmEmpty === true}" v-model="passwordConfirm" type="password" class="input form-control border-0" data-type="password" placeholder="Γράψε ξανά τον κωδικό σου" required>
							<div v-if="passwordConfirmEmpty" class="warn-info">{{ passwordConfirmMessage }}</div>
						</div>
						<div class="group py-2">
							<div class="custom-control custom-checkbox" style="cursor: pointer;">
								<input id="termsAccept" v-model="termsAccept" type="checkbox" class="custom-control-input" style="cursor: pointer;" required>
								<label class="custom-control-label" for="termsAccept" style="cursor: pointer;">Αποδέχομαι τους όρους χρήσης</label>
								<div v-if="termsButtonNotChecked" class="warn-info">Πρέπει να αποδεχτείς τους όρους χρήσης.</div>
							</div>
						</div>
						<div class=" mt-4 py-2">
							<button type="submit" class="btn btn-block text-white mainbtn">Εγγραφή</button>
							<div :class="{ 'lds-dual-ring': isLoading, 'my-3': isLoading }" class="d-flex justify-content-center pt-2">
								<p class='my-1 warn-info'>{{ hasErrorMsg }}</p>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Form',
	props: ['signupCompleted'],
	data() {
		return {
			email: '',
			isEmailEmpty: false,
			warnMsg: '',
			passwordMessage: '',
			passwordConfirmMessage: '',
			password: '',
			passwordConfirm: '',
			isPasswordEmpty: false,
			passwordConfirmEmpty: false,
			name: '',
			surname: '',
			mobile: '',
			isNameEmpty: false,
			isSurnameEmpty: false,
			isMobileEmpty: false,
			isLoading: false,
			termsAccept: false,
			termsButtonNotChecked: false,
			hasErrorMsg: '',
			formIsOk: false
		}
	},

	mounted() {
		document.addEventListener('visibilitychange', this.visibilityChange);
	},

	methods: {
		visibilityChange: function() {
			this.isPasswordEmpty = false;
			this.isEmailEmpty = false;
			this.isNameEmpty = false;
			this.isSurnameEmpty = false;
			this.isMobileEmpty = false;
			this.passwordConfirmEmpty = false;
			this.termsButtonNotChecked = false;
		},

		CheckNameValue: function() { 
			if (this.name === '') {
				this.isNameEmpty = true;
				this.formIsOk = false;
			}
			else {
				this.isNameEmpty = false;
				this.formIsOk = true;
			}
		},

		CheckSurnameValue: function() {
			if (this.surname === '') {
				this.isSurnameEmpty = true;
				this.formIsOk = false;
			}
			else {
				this.isSurnameEmpty = false;
				this.formIsOk = true;
			}
		},

		CheckMobileValue: function() {
			if (this.mobile === '') {
				this.isMobileEmpty = true;
				this.formIsOk = false;
			}
			else {
				this.isMobileEmpty = false;
				this.formIsOk = true;
			}
		},

		CheckPassValue: function() {
			if (this.password === '') {
				this.isPasswordEmpty = true;
				this.passwordMessage = 'Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης';
				this.formIsOk = false;
			}
			else if (this.password.length <= 9) {
				this.isPasswordEmpty = true;
				this.passwordMessage = 'Ο κωδικός πρόσβασης πρέπει να έιναι μεγαλύτερος από 9 χαρακτήρες';
				this.formIsOk = false;
			}
			else {
				this.isPasswordEmpty = false;
				this.formIsOk = true;
			}
		},

		CheckPassConfirmValue: function() {
			if (this.passwordConfirm === '') {
				this.passwordConfirmEmpty = true;
				this.passwordConfirmMessage = 'Πρέπει να συμπληρώσεις ξανά τον κωδικό πρόσβασης.';
				this.formIsOk = false;
			}
			else if (this.passwordConfirm !== this.password) {
				this.passwordConfirmEmpty = true;
				this.passwordConfirmMessage = 'Ο κωδικός δεν είναι ίδιος με τον προηγούμενο.';
				this.formIsOk = false;
			}
			else {
				this.passwordConfirmEmpty = false;
				this.formIsOk = true;
			}
		},

		CheckEmail: function() {
			if (!this.EmailValidated(this.email) && this.email !== '') {
				this.warnMsg = 'Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.';
				this.isEmailEmpty = true;
			}
			else if (this.email === '') {
				this.warnMsg = 'Πρέπει να συμπληρώσεις το email σου.';
				this.isEmailEmpty = true;
			}
			else {
				this.isEmailEmpty = false;
			}
		},

		CheckTermsAccept: function() {
			if (this.termsAccept === false){
				this.termsButtonNotChecked = true;
				this.formIsOk = false;
			}
			else {
				this.termsButtonNotChecked = false;
				this.formIsOk = true;
			}
		},

		EmailValidated: function(email) {
			const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		},

		FormValidated: function() {

			this.CheckNameValue()
			this.CheckSurnameValue();
			this.CheckMobileValue();
			this.CheckPassValue();
			this.CheckPassConfirmValue();
			this.CheckTermsAccept();

			if (!this.EmailValidated(this.email) && this.email !== '' && this.formIsOk) {
				this.warnMsg = 'Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.';
				this.isEmailEmpty = true;
			}
			else if (this.email === '') {
				this.warnMsg = 'Πρέπει να συμπληρώσεις το email σου.';
				this.isEmailEmpty = true;
			}
			else {
				this.isEmailEmpty = false;
			}
			return this.formIsOk;
		},

		SignUp: async function() {
			if(this.FormValidated() && this.EmailValidated(this.email)){
				this.hasErrorMsg = '';
				this.isLoading = true;

				try {
					let params = {
						email: this.email,
						password: this.password,
						passwordConfirm: this.passwordConfirm,
						name: this.name,
						surname: this.surname,
						mobile: this.mobile,
						termsAccept: this.termsAccept
					}
					
					let response = await fetch('http://localhost:3000/auth/signup', {
						method: 'POST',
						body: JSON.stringify(params),
						headers: {
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					let resolve = await response.json();
					if (response.ok) {

						if (resolve.status === "ok") {
							this.isLoading = false;
							let signUpOk = true;
							this.$emit("SignUpSuccessful", signUpOk);
						}
						else if (resolve.errors) {
							this.isLoading = false;
							this.hasErrorMsg = resolve.errors[0].msg;
						}
						else if (resolve.error){
							this.isLoading = false;
							this.hasErrorMsg = resolve.error;
						}
					}
					else if (!response.ok) {
						this.isLoading = false;
						this.hasErrorMsg = resolve.error;
					}
				}
				catch (error) {
					this.isLoading = false;
					this.hasErrorMsg = error;
				}
			}
		}
	},
}
</script>

<style scoped>
.warn-info {
	font-size: 15px !important;
	color: #dc3545 !important;
}

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
	padding: 22px 15px !important;
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