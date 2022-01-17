<template>
	<div>
		<div class="background">
			<Header :userInfo="userInfo"/>
			<div class="container py-3" v-if="orderNotSent">
				<h1>Ολοκλήρωση Παραγγελίας</h1>
			</div>
		</div>
		<div class="container-fluid my-5">
			<form v-if="orderNotSent" v-on:submit.prevent="sendOrder" class="row d-flex justify-content-center" novalidate>
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
						<textarea v-model="comments" class="form-control" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
					</div>
				</div>
				<div class="col-xl-3 col-md-12 col-12 card box shadow-lg p-xl-5 p-md-5 mx-3">
					<h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
					<div class="form-group">
						<div class="d-block mt-4">
							<select v-model.trim="$v.payment.$model" name="payment_method" class="form-select pointer-base">
								<option value="none" selected disabled>Επέλεξε έναν τρόπο πληρωμής</option>
								<option value="cash">Μετρητά</option>
								<option value="paypal">Paypal</option>
								<option value="credit">Χρεωστική/Πιστωτική κάρτα</option>
							</select>
							<div v-if="$v.payment.$dirty && !$v.payment.type" class="text-danger">Πρέπει να διαλέξεις έναν τρόπο πληρωμής.</div>
						</div>
						<div v-if="payment === 'cash'" class="mt-3">
							Θα πληρώσεις με τον κλασικό τρόπο κατα την παράδοση
						</div>
						<div v-if="payment === 'credit'">

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
									<p class='text-muted m-0'>{{ product.size > 1 ? product.size + 'πλος' : 'Μονός' }}, {{ product.blends + ', ' + product.sugar + ', ' + product.sugarType }}</p>
								</div>
								<div>
									<p class="text-center">{{ product.price.toFixed(2).replace('.', ',') }}€</p>
								</div>
							</div>
						</b-list-group-item>
						<b-list-group-item>
							<section class="d-flex justify-content-between">
								<h6 class="m-0">Συνολικό Κόστος</h6>
								<h6 class="m-0">{{ sum.toFixed(2).replace('.', ',') }}€</h6>
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
			<div v-else-if="awaitConfirmation" class="confirm-section d-flex flex-column align-items-center justify-content-center mx-auto my-5 py-5">
				<b-spinner style="width: 4.2rem; height: 4.2rem;" type="grow" class="mt-5 mb-4"></b-spinner>
				<b-jumbotron header-level="5" header="Αποστολή παραγγελίας σε εξέλιξη" class="text-center">
					<p>Η παραγγελία σου έχει φύγει από εμάς και περιμένουμε την επιβεβαίωση του καταστήματος.
						<strong>Παρακαλούμε μην πατήσεις ανανέωση και μη κλείσεις το παράθυρο!</strong>
					</p>
				</b-jumbotron>
			</div>
			<div v-else-if="orderConfirmed">
				<b-alert show variant="success" class="d-flex flex-column align-items-center justify-content-center mx-auto my-5 py-5 w-50">
					<b-icon font-scale="8" icon="check-circle-fill"></b-icon>
					<h1 class="alert-heading text-center my-3 w-75">Η παραγγελία σου θα παραδωθεί σε 10'</h1>
					<p class="text-center w-75 mt-4 mb-0">Ώρα επιβεβαίωσης: {{ orderSummary.date }}</p>
					<a class="mt-4" href='http://localhost:8080'>Επιστροφή στην αρχική</a>
				</b-alert>
			</div>
			<div v-else-if="orderCancel.status">
				<b-alert show variant="danger" class="d-flex flex-column align-items-center justify-content-center mx-auto my-5 py-5 w-50">
					<b-icon font-scale="5" icon="exclamation-circle-fill"></b-icon>
					<h3 class="alert-subheading text-center my-3 w-75">Η παραγγελία σου ακυρώθηκε με τον εξής λόγο: {{ orderCancel.reason }}</h3>
					<a class="mt-4 text-white" href='http://localhost:8080'>Επιστροφή στην αρχική</a>
				</b-alert>
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
import router from '../router';
import { io } from 'socket.io-client';

const type = (value) => value === 'cash' || value === 'paypal' || value === 'credit'; 

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
			orderSummary: {},
			orderNotSent: true,
			awaitConfirmation: false,
			orderConfirmed: false,
			orderCancel: {
				status: false,
				reason: ''
			},
			payment: 'none',
			phone: '',
			ringbell: '',
			floor: '',
			comments: '',
			cart: [],
			sum: 0,
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
			type
		}
	},

	async created() {
		// FETCH STORES
		try {
			const response = await fetch('http://' + this.$store.state.base_url + ':3000/stores/' + this.store_id, {
				method: 'GET',
				headers: {
					"Authorization" : this.$cookies.get('token'),
				}
			});
			
			if (response.ok) {
				const res = await response.json();

				if (res.error) {
					if ('tokenMalformed' in res.error) {
						this.sessionExpiredHandler(res.error.message);
					}
				}

				if (res.store) {
					this.store = res.store;
				}
				else {
					router.push('/stores');
					throw res.error
				}
			}
			else if (!response.ok){
				throw response.status;
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

		// FETCH USER'S CART
		try {
			const response = await fetch('http://' + this.$store.state.base_url + ':3000/checkout/cart', {
				method: 'GET',
				headers: {
					"Authorization" : this.$cookies.get('token'),
				}
			});

			if (response.ok) {
				const res = await response.json();

				if (res.error) {
					if ('tokenMalformed' in res.error) {
						this.sessionExpiredHandler(res.error.message);
					}
					else {
						throw res.error
					}
				}

				if (res.cart && res.sum) {
					this.cart = res.cart;
					this.sum = res.sum;
				}
			}
			else if (!response.ok){
				throw response;
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
	},

	mounted() {
		NProgress.done();
	},

	methods: {
		sendOrder: async function() {
			this.$v.$touch();

			if (!this.$v.$invalid) {
				NProgress.start();

				try {
					let user = this.$store.state.userInfo;

					user.address = this.$cookies.get('actaddr');
					user.payment = this.payment;
					user.ringbell = this.ringbell;
					user.floor = this.floor;
					user.phone = this.phone;
					user.comments = this.comments;

					let order = {
						store: this.store,
						cart: this.cart,
						user: user
					};

					const response = await fetch('http://' + this.$store.state.base_url + ':3000/checkout/sendorder', {
						method: 'POST',
						headers: {
							"Authorization" : this.$cookies.get('token'),
							"Content-type" : "application/json; charset=UTF-8"
						},
						body: JSON.stringify({
							'order': order
						}),
					});

					if (response.ok) {
						let orderState = await response.json();

						if (orderState.error) {
							if ('tokenMalformed' in orderState.error) {
								this.sessionExpiredHandler(orderState.error.message);
							}
						}

						if (orderState.sent_success) {
							this.orderNotSent = false;
							this.awaitConfirmation = true;

							const token = this.$cookies.get('token');

							// !Reminder: Change domain for socket in prod
							var socket = io('http://' + this.$store.state.base_url + ':3000', {
								transports: ["websocket"],
								query: {
									token		
								}
							});

							socket.on("connect", () => socket.emit("order:client:changes", orderState.order_id));

							this.$store.state.userCart.products.length = 0;
							this.$store.state.userCart.store_id = '';
						}
					}

					socket.on('order:client:confirmed', (orderDate) => {
						NProgress.start();

						this.orderSummary.date = orderDate;
						this.awaitConfirmation = false;
						this.orderConfirmed = true;

						socket.emit("order:client:disconnect");

						NProgress.done();
					});

					socket.on('order:client:cancelled', (response) => {
						NProgress.start();

						this.awaitConfirmation = false;
						this.orderCancel.status = true;
						this.orderCancel.reason = response;

						socket.emit("order:client:disconnect");

						NProgress.done();
					});

					socket.on('order:client:error', (error_msg) => {

						this.orderNotSent = true;
						this.awaitConfirmation = false;
						this.orderConfirmed = false;
						this.orderCancel = {
							status: false,
							reason: ''
						};
						
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Cofy',
							text: error_msg
						});
					});
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
.confirm-section {
	max-width: 600px;
}

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