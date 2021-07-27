<template>
	<div>
		<div class="background">
			<Header :userInfo="userInfo"/>
			<div class="container py-3">
				<h1>Ολοκλήρωση Παραγγελίας</h1>
			</div>
		</div>
		<div class="container-fluid my-5">
			<form v-on:submit.prevent="sendOrder" class="row d-flex justify-content-center" novalidate>
				<div class="col-xl-3 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5 mx-3">
					<h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
					<div class="row my-2">
						<div class="col-xl-9 col-12">
							<label>Όνομα στο κουδούνι*</label>
							<input type="text" v-model.trim="$v.ringbell.$model" class="form-control" required>
							<div v-if="!$v.ringbell.required && $v.ringbell.$dirty" class="text-danger">Πρέπει να συμπληρώσεις όνομα στο κουδούνι.</div>
						</div>
						<div class="col-3">
							<label>Όροφος*</label>
							<input v-model.trim="$v.floor.$model" type="text" class="form-control" required>
							<div v-if="!$v.floor.required && $v.floor.$dirty" class="text-danger">Πρέπει να συμπληρώσεις τον όροφο.</div>
						</div>
					</div>
					<div class="my-2">
						<label>Προαιρετικό τηλ. επικοινωνίας</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group my-2">
						<label>Σχόλια διεύθυνσης</label>
						<textarea class="form-control" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
					</div>
				</div>
				<div class="col-xl-3 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5 mx-3">
					<h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
					<div class="form-group">
						<div class="d-block mt-4">
							<div class="list-group form-check">
								<select v-model.trim="$v.payment.$model" name="payment_method" class="form-select pointer-base">
									<option value="none" selected disabled>Επέλεξε έναν τρόπο πληρωμής</option>
									<option value="cash">Μετρητά</option>
									<option value="paypal">Paypal</option>
									<option value="crdeit">Χρεωστική/Πιστωτική κάρτα</option>
								</select>
								<div v-if="!$v.payment.required && $v.payment.$dirty" class="text-danger">Πρέπει να διαλέξεις έναν τρόπο πληρωμής.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5 mx-3">
					<h4 class="mb-4">3. Σύνοψη παραγγελίας</h4>
					<b-list-group class="mb-1">
						<b-list-group-item v-for="(product, index) in cart" :key="index">
							<div class="d-flex justify-content-between">
								<div class="row">
									<p class="m-0">{{ product.name }}</p>
									<p class='text-muted cc-p-font m-0'>{{ product.size > 1 ? product.size + 'πλος' : 'Μονός' }}, {{ product.blends + ', ' + product.sugar + ', ' + product.sugarType }}</p>
								</div>
								<div>
									<p class="text-center">2,50€</p>
								</div>
							</div>
						</b-list-group-item>
						<b-list-group-item>
							<section class="d-flex justify-content-between">
								<h6 class="m-0">Συνολικό Κόστος</h6>
								<h6 class="m-0">price€</h6>
							</section>
						</b-list-group-item>
					</b-list-group>
					<div class="card my-2">
						<div class="d-flex">
							<div class="card-body flex-grow-0">
								<img :src="store.logo" class="store-img">
							</div>
							<div class="card-body flex-grow-1">
								<h6 class="card-title mb-1">{{ store.name }}</h6>
								<p class="card-text text-muted">{{ store.location }}</p>
							</div>
						</div>
					</div>
					<button type="submit" class="btn mainbtn my-2">Αποστολή Παραγγελίας</button>
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
import router from '../router';

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
			payment: 'none',
			cart: this.$store.state.userCart.products,
			store_id: this.$store.state.userCart.store_id,
			store: {}
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
		}
	},

	methods: {
		SumPrice: function() {
			
		}
	},

	async created() {
		const token = this.$cookies.get('token');

		if (token) {
			try {
				const response = await fetch('http://' + this.$store.state.base_url + ':3000/stores/id/' + this.store_id, {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});
				
				if (response.ok) {
					const res = await response.json();

					if (res.store) {
						this.store = res.store;
					}
					else {
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: 'Unexpected error: ' + res.error
						});
						router.push('/stores');
					}
				}
				else if (!response.ok){
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: 'Unexpected error: ' + response.status
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

	mounted() {
		NProgress.done();
	},

	beforeRouteLeave (to, from, next) {
		// Remove StoreID each time stores page load
		try {
			const responseStoreRemoval = await fetch('http://' + this.$store.state.base_url + ':3000/stores/remove', {
				method: 'DELETE',
				headers: {
					"Authorization" : token,
				}
			});

			if (responseStoreRemoval.ok) {
				const resStoreRemoved = responseStoreRemoval.json();

				if (resStoreRemoved.ok) {
					this.$store.state.userCart.store_id = '';
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
		finally {
			next();
		}
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
.box {
	border-radius: .9rem;
}

@media screen and (min-width: 280px) and (max-width: 400px){
  .box {
    padding: 20px !important;
  }
}

@media screen and (min-width: 400px) and (max-width: 850px){
  .box {
    padding: 20px !important;
  }
}

.store-img {
	width: 50px;
}
</style>