<template>
	<div>
		<div class="background">
			<nav class="navbar py-4 d-flex justify-content-center">
				<router-link to="/" class="navbar-brand">
					<img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
				</router-link>
			</nav>
			<div v-if="signupCompleted" class="container py-5">
				<div class="alert alert-success rounded" role="alert">
					<div class="text-center">
						<img src="/images/success.png" class="image-success" alt="Success">
					</div>
					<h2 class="text-center">Καλωσήρθες στο Chip Coffee!</h2>
					<p class="text-center">Η εγγραφή σου έγινε με επιτυχία. Θα λάβεις ένα email για την επιβεβαίωση του λογαριασμού σου.</p>
					<div class="d-flex justify-content-center">
						<router-link role="button" class="btn btn-sm mainbtn" to="/">Πίσω στην αρχική</router-link>
					</div>
				</div>
			</div>
			<div v-else class="mx-auto col-xxl-4 col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 py-xl-4 py-lg-3 py-md-3 py-sm-2 p-0">
				<div class="signup-snip text-white user-select-none">
					<h2>Εγγραφή</h2>
					<Form :signupCompleted="signupCompleted" @SignUpSuccessful="SignUpOk"/>			
				</div>
			</div>
		</div>
		<Sale/>
		<Footer/>
	</div>
</template>

<script>
import Form from '../components/Register/Form';
import Sale from '../components/layout/Sale';
import Footer from '../components/layout/Footer';

export default {
	name: 'Signup',
	
	components: {
		Sale,
		Form,
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

.logo {
	height: 100px !important;
}

.image-success {
	width: 250px;
}

.signup-snip {
	width: 100%;
	border-radius: 23px;
	padding: 50px;
	background: #301504d2;
	backdrop-filter: blur(25px);
}
</style>