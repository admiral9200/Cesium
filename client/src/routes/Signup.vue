<template>
	<div>
		<div class="background">
			<SignUpHeader/>
			<div v-if="signupCompleted" class="py-3 p-0">
				<div class="container">
					<div class="alert alert-success rounded" role="alert">
						<div class="text-center">
							<img src="/images/success.png" class="image-success" alt="Success">
						</div>
						<h1 class="text-center">Καλωσήρθες στο Chip Coffee!</h1>
						<p class="text-center">Η εγγραφή σου έγινε με επιτυχία. Θα λάβεις ένα email για την επιβεβαίωση του λογαριασμού σου.</p>
						<div class="row justify-content-center">
							<router-link role="button" class="btn mainbtn btn-lg" to="/">Πίσω στην αρχική</router-link>
						</div>
					</div>
				</div>
			</div>
			<div v-else class="py-1 p-0">
				<div class="mx-auto col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 py-xl-4 py-lg-4 py-md-3 py-sm-2 p-0">
					<div class="signup-snip text-white user-select-none">
						<h1>Εγγραφή</h1>
						<Form :signupCompleted="signupCompleted" @SignUpSuccessful="SignUpOk"/>			
					</div>
				</div>
			</div>
		</div>
		<Sale/>
		<Newsletter/>
		<Footer/>
	</div>
</template>

<script>
import SignUpHeader from '../components/layout/SignUpHeader';
import Form from '../components/Register/Form';
import Newsletter from '../components/layout/Newsletter';
import Sale from '../components/layout/Sale';
import Footer from '../components/layout/Footer';

export default {
	name: 'Signup',
	components: {
		Sale,
		Form,
		Newsletter,
		SignUpHeader,
		Footer
	},

	data() {
		return {
			signupCompleted: false
		}
	},

	methods: {
		SignUpOk: function (signUpOk) {
			this.signupCompleted = signUpOk;
		}
	},
}
</script>

<style scoped>
@media screen and (min-width: 280px) and (max-width: 400px) {
	.signup-snip {
		border-radius: 0 !important;
		min-width: 200px !important;
		padding: 20px 20px 20px 20px !important;
	}
}

.image-success {
	width: 250px;
}

.signup-snip {
	width: 100%;
	border-radius: 23px;
	padding: 40px;
	background: #301504ea;
	backdrop-filter: blur(25px);
}
</style>