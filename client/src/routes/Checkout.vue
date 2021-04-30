<template>
	<div>
		<div class="background">
			<Header :userInfo="userInfo"/>
			<div class="container py-3">
				<h1>Ολοκλήρωση Παραγγελίας</h1>
			</div>
		</div>
		<div class="container my-5">
			<div class="row d-flex justify-content-center">
				<div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
					<h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
					<div class="row">
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
					<div class="space">
						<label>Προαιρετικό τηλ. επικοινωνίας</label>
						<input type="number" class="form-control">
					</div>
					<div class="form-group">
						<label>Σχόλια διεύθυνσης</label>
						<textarea class="form-control" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
					<h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
					<div class="form-group">
						<div class="d-block mt-4">
							<div class="list-group form-check">
								<input class="form-check-input" type="radio" name="payment" value="paypal" id="paypal" required/>
								<label class="list-group-item form-check-label" for="paypal">PayPal</label>
								<input class="form-check-input" type="radio" name="payment" value="credit" id="card" required/>
								<label class="list-group-item form-check-label" for="card">Πιστωτική/Χρεωστική Κάρτα</label>
								<div class="text-danger">Πρέπει να διαλέξεις έναν τρόπο πληρωμής.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
					<h4 class="d-flex justify-content-between align-items-center mb-4">3. Ολοκλήρωση</h4>
					<ul class="list-group mb-1"></ul>
					<button type="submit" class="btn mainbtn text-white btn-lg btn-block my-2">Αποστολή Παραγγελίας</button>
				</div>
			</div>
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

	validations: {
		floor: {
			required
		},
		ringbell: {
			required
		},
		phone: {
			numeric
		}
	},

	mounted() {
		NProgress.done();
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

.chk {
  width: 150px;
}

@media screen and (min-width: 280px) and (max-width: 400px){
  .container {
    width: 100% !important;
  }
  .box {
    padding: 20px !important;
  }
  .logo {
    height: 50px !important;
    width: auto;
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
  .container {
    width: 100% !important;
  }
  .logo {
    height: 70px !important;
    width: auto;
  }
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

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

.box {
  box-shadow: 0 5px 2px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.048) !important;
  border: 0.5px solid rgba(0, 0, 0, 0.24);
  border-radius: 1%;
}

.list-group-item {
  user-select: none;
}

.list-group input[type="checkbox"] {
  display: none;
}

.list-group input[type="checkbox"] + .list-group-item {
  cursor: pointer;
}

.list-group input[type="checkbox"] + .list-group-item:before {
  content: "\2713";
  color: transparent;
  font-weight: bold;
  margin-right: 1em;
}

.list-group input[type="checkbox"]:checked + .list-group-item {
  background-color: #bb6b00;
  color: #fff;
}

.list-group input[type="checkbox"]:checked + .list-group-item:before {
  color: inherit;
}

.list-group input[type="radio"] {
  display: none;
}

.list-group input[type="radio"] + .list-group-item {
  cursor: pointer;
}

.list-group input[type="radio"] + .list-group-item:before {
  content: "\2022";
  color: transparent;
  font-weight: bold;
  margin-right: 1em;
}

.list-group input[type="radio"]:checked + .list-group-item {
  background-color: #bb6b00;
  color: #fff;
}

.list-group input[type="radio"]:checked + .list-group-item:before {
  color: inherit;
}

</style>