<template>
	<div>
		<div class="background">
			<Header :userInfo="userInfo"/>
			<div class="container py-3">
				<h1>Ολοκλήρωση Παραγγελίας</h1>
			</div>
		</div>
		<div class="container my-5">
			<form v-on:submit.prevent="sendOrder" class="row d-flex justify-content-center">
				<div class="col-xl-4 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5">
					<h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
					<div class="row my-2">
						<div class="col-xl-8 col-12">
							<label>Όνομα στο κουδούνι*</label>
							<input type="text" v-model.trim="$v.ringbell.$model" class="form-control" required>
							<div v-if="!$v.ringbell.required && $v.ringbell.$dirty" class="text-danger">Πρέπει να συμπληρώσεις όνομα στο κουδούνι.</div>
						</div>
						<div class="col-md-4">
							<label>Όροφος*</label>
							<input v-model.trim="$v.floor.$model" type="number" class="form-control" required>
							<div v-if="!$v.floor.required && $v.floor.$dirty" class="text-danger">Πρέπει να συμπληρώσεις τον όροφο.</div>
						</div>
					</div>
					<div class="my-2">
						<label>Προαιρετικό τηλ. επικοινωνίας</label>
						<input type="number" class="form-control">
					</div>
					<div class="form-group my-2">
						<label>Σχόλια διεύθυνσης</label>
						<textarea class="form-control" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5">
					<h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
					<div class="form-group">
						<div class="d-block mt-4">
							<div class="list-group form-check">
								<select v-model.trim="$v.payment.$model" name="payment_method" class="form-select pointer-base">
									<option value="none" selected disabled>Επέλεξε έναν τρόπο πληρωμής</option>
									<option value="1">Μετρητά</option>
									<option value="2">Paypal</option>
									<option value="3">Χρεωστική/Πιστωτική κάρτα</option>
								</select>
								<div v-if="!$v.payment.required && !$v.payment.numeric && $v.payment.$dirty" class="text-danger">Πρέπει να διαλέξεις έναν τρόπο πληρωμής.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5">
					<h4 class="d-flex justify-content-between align-items-center mb-4">3. Ολοκλήρωση</h4>
					<ul class="list-group mb-1"></ul>
					<button type="submit" class="btn mainbtn text-white btn-lg btn-block my-2">Αποστολή Παραγγελίας</button>
				</div>
			</form>
		</div>
		<Sale/>
		<Footer/>
	</div>
</template>

<script>
import Sale from '../components/layout/Sale';
import Header from '../components/layout/Header';
import Footer from '../components/layout/Footer';
import NProgress from 'nprogress';
import { required, numeric } from 'vuelidate/lib/validators';

export default {
	name: 'Checkout',

	props: ['userInfo'],

	components: { 
		Sale,
		Header,
		Footer
	},

	data() {
		return {
			payment: 'none'
		}
	},

	validations: {
		floor: {
			required
		},
		ringbell: {
			required
		},
		phone: {
			numeric
		},
		payment: {
			required,
			numeric
		}
	},

	mounted() {
		NProgress.done();
	},

	methods: {
		sendOrder: function() {
			this.$v.$touch();

			if (!this.$v.$invalid) {
				try {
					NProgress.start();	
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
.background h1 {
  color: white;
  padding: 10%;
  padding-left: 0;
  padding-bottom: 0;
  text-align: left;
  font-size: 75px;
  font-weight: 300;
}

.background h2{
	color: white;
	font-weight: 300;
}

.background h3{
  color: white;
  padding: 3%;
  padding-left: 0;
  text-align: left;
  font-size: 20px;
  font-weight: 300;
}

.box {
	border-radius: .9rem;
}

@media screen and (min-width: 280px) and (max-width: 400px){
  .box {
    padding: 20px !important;
  }
  .background h1 {
    font-size: 40px !important;
    padding-right: 0 !important;
  }
  .background h3 {
    text-align: center !important;
  }
}

@media screen and (min-width: 400px) and (max-width: 600px){
  .box {
    padding: 20px !important;
  }
  .background h1 {
    font-size: 40px !important;
    padding-right: 0 !important;
  }
  .background h3 {
    text-align: center !important;
  }
}
</style>