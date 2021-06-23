<template>
	<div>
		<a type="button" class="text-dark w-100" v-b-modal="'cc' + coffee._id">
			<div class="card">
				<div class="card-body p-1">
					<h6 class="card-title">{{ coffee.name }}</h6>
					<h6 class="card-subtitle text-muted">Από {{ coffee.price }}€</h6>
				</div>
			</div>
		</a>
		<b-modal :id="'cc' + coffee._id" @show="ResetForm" @hidden="ResetForm" @ok="handleAddToCart" lazy no-stacking ok-only ok-variant="dark" ok-title="Προσθήκη στο καλάθι">
			<template #modal-title>
				<div class="d-grid">
					<h5>{{ coffee.name }}</h5>
					<h6 class="text-muted my-1">{{ coffee.price }}€</h6>
				</div>
			</template>
			<template>
				<form v-on:submit.prevent="AddToCart" class="user-select-none">
					<div class="row justify-content-between">
						<h6>Επιλέξτε μέγεθος*</h6>
						<div v-if="!$v.CoffeeSize.required && $v.CoffeeSize.$dirty" class="text-danger">Πρέπει να διαλέξεις το μέγεθος του καφέ</div>
						<div v-for="(coffeeSize, index) in coffee.size" :key="index" class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
							<input v-model.trim="$v.CoffeeSize.$model" :value="coffeeSize" class="form-check-input cc-input m-0 pointer-base" type="radio" :name="coffee.name" :id="coffee.name + coffee._id + index">
							<label class="form-check-label ps-2 pointer-base" :for="coffee.name + coffee._id + index">{{ index === 0 ? 'Μονός' : coffeeSize + 'πλος' }}</label>
						</div>
					</div>
					<div class="row justify-content-between">
						<h6 class="mt-3">Επιλέξτε ζάχαρη*</h6>
						<div v-if="!$v.CoffeeSugar.required && $v.CoffeeSugar.$dirty" class="text-danger">Πρέπει να διαλέξεις τη ζάχαρη του καφέ</div>
						<div v-for="(type, index) in sugar" :key="index" class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
							<input v-model.trim="$v.CoffeeSugar.$model" :value="type" class="form-check-input cc-input m-0 pointer-base" type="radio" :name="coffee._id + coffee.name + 'Sugar'" :id="type + coffee.name + coffee._id + index">
							<label class="form-check-label ps-2 pointer-base" :for="type + coffee.name + coffee._id + index">{{ type }}</label>
						</div>
					</div>
					<div class="row justify-content-between">
						<h6 class="mt-3">Επιλέξτε είδος ζάχαρης*</h6>
						<div v-if="!$v.CoffeeSugarType.required && $v.CoffeeSugarType.$dirty" class="text-danger">Πρέπει να διαλέξεις τον τύπο ζάχαρης του καφέ</div>
						<div v-for="(sugarType, index) in sugarTypes" :key="index" class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
							<input v-model.trim="$v.CoffeeSugarType.$model" :value="sugarType" class="form-check-input cc-input m-0 pointer-base" type="radio" :name="coffee._id + coffee.name + 'SugarType'" :id="sugarType + coffee.name + coffee._id + index">
							<label class="form-check-label ps-2 pointer-base" :for="sugarType + coffee.name + coffee._id + index">{{ sugarType }}</label>
						</div>
					</div>
					<div v-if="coffee.blends.length > 0" class="row justify-content-between">
						<h6 class="mt-3">Επιλέξτε ποικιλία</h6>
						<div v-if="!$v.CoffeeBlends.required && $v.CoffeeBlends.$dirty" class="text-danger">Πρέπει να διαλέξεις μία ποικιλία καφέ</div>
						<div v-for="(blend, index) in coffee.blends" :key="index" class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" :for="blend + coffee.name + coffee._id + index">
							<input v-model.trim="$v.CoffeeBlends.$model" :value="blend" class="form-check-input cc-input m-0 pointer-base" type="radio" :name="coffee._id + coffee.name + 'Blend'" :id="blend + coffee.name + coffee._id + index">
							<label class="form-check-label ps-2 pointer-base" :for="blend + coffee.name + coffee._id + index">{{ blend }}</label>
						</div>
					</div>
					<div class="row justify-content-between">
						<h6 class="mt-3">Decaf</h6>
						<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3">
							<input v-model.trim="CoffeeDecaf" class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" :id="coffee._id + coffee.name + 'Decaf'">
							<label class="form-check-label ps-2 pointer-base" :for="coffee._id + coffee.name + 'Decaf'">Ναι</label>
						</div>
					</div>
					<div v-if="coffee.adds.length > 0" class="row justify-content-between">
						<h6 class="mt-3">Προσθέστε</h6>
						<div v-for="(add, index) in coffee.adds" :key="index" class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3">
							<input v-model.trim="CoffeeAdds" :value="add" class="form-check-input cc-input m-0 pointer-base" type="checkbox" :name="coffee._id + coffee.name + 'ADDS'" :id="coffee._id + coffee.name + index + 'ADD'">
							<label class="form-check-label ps-2 pointer-base" :for="coffee._id + coffee.name + index + 'ADD'">{{ add }}</label>
						</div>
					</div>
					<div v-if="coffee.extras.length > 0" class="row justify-content-between">
						<h6 class="mt-3">Προσθέστε extra</h6>
						<div v-for="(extra, index) in coffee.extras" :key="index" class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3">
							<input v-model.trim="CoffeeExtras" class="form-check-input cc-input m-0 pointer-base" type="checkbox" :name="coffee._id + coffee.name + 'EXTRA'" :id="coffee._id + coffee.name + 'EXTRA'">
							<label class="form-check-label ps-2 pointer-base" :for="coffee._id + coffee.name + 'EXTRA'">{{ extra }}</label>
						</div>
					</div>
					<div class="row">
						<h6 class="mt-3">Ποσότητα</h6>
						<div class="input-group">
							<button v-on:click="quantityMinus" type="button" class="btn cart_btn">-</button>
							<input class="cart-input" :value="CoffeeQuantity" disabled/>
							<button v-on:click="CoffeeQuantity++" type="button" class="btn cart_btn">+</button>
						</div>
					</div>
				</form>
			</template>
		</b-modal>
		<hr class="my-3">
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';
import { required, numeric, minLength } from 'vuelidate/lib/validators';
import NProgress from 'nprogress';

export default {
	name: 'MenuItem',

	props: ['coffee'],

	data() {
		return {
			CoffeeSize: null,
			CoffeeSugar: null,
			CoffeeSugarType: null,
			CoffeeBlends: null,
			CoffeeDecaf: false,
			CoffeeAdds: [],
			CoffeeExtras: [],
			CoffeeQuantity: 1,
			sugar: ['Σκέτος', 'Μέτριος', 'Γλυκός'],
			sugarTypes: ['Λευκή ζάχαρη', 'Καστανή ζάχαρη', 'Μαύρη ζάχαρη', 'Stevia']
		}
	},

	validations: {
		CoffeeSize: {
			required,
			numeric
		},

		CoffeeSugar: {
			required
		},

		CoffeeSugarType: {
			required
		},

		CoffeeQuantity: {
			required,
			minLength: minLength(1)
		},

		CoffeeBlends: {
			required
		}
	},

	methods: {
		quantityMinus: function() {
			if (this.CoffeeQuantity > 1) this.CoffeeQuantity--;
		},

		ResetForm: function() {
			this.CoffeeQuantity = 1;
			this.CoffeeSize = null;
			this.CoffeeSugar = null;
			this.CoffeeSugarType = null;
			this.CoffeeBlends = null;
			this.CoffeeDecaf = false;
			this.CoffeeAdds = [];
			this.CoffeeExtras = [];
			this.$v.CoffeeSize.$reset();
			this.$v.CoffeeSugar.$reset();
			this.$v.CoffeeSugarType.$reset();
			this.$v.CoffeeQuantity.$reset();
			this.$v.CoffeeBlends.$reset();
		},

		handleAddToCart: function(event) {
			event.preventDefault();
			this.AddToCart();
		},

		AddToCart: async function() {
			const token = VueCookies.get('token');
			this.$v.$touch();

			if (token && !this.$v.$invalid) {
				NProgress.start();
				try {	
					const response = await fetch('http://localhost:3000/order/cart', {
						method: 'POST',
						headers: {
							"Content-type" : "application/json; charset=UTF-8",	
							"Authorization" : token,
						},
						body: JSON.stringify({
							user_id: this.$store.state.userInfo.id,
							c_name: this.coffee.name,
							c_size: this.CoffeeSize,
							c_qty: this.CoffeeQuantity,
							c_sugar: this.CoffeeSugar,
							c_sugartype: this.CoffeeSugarType,
							c_decaf: this.CoffeeDecaf,
							c_blends: this.CoffeeBlends,
							c_adds: this.CoffeeAdds,
							c_extras: this.CoffeeExtras,
						})
					});

					if (response.ok) {
						const res = await response.json();
						
						if (res.success) {

							this.$bvModal.hide('cc' + this.coffee._id);

							this.$root.$emit('Cart Update');

							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Chip Coffee',
								text: res.msg
							});
						}
						else if (res.error) {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Chip Coffee',
								text: res.error
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
				finally {
					NProgress.done();
				}
			}
		}
	},

	destroyed() {
		this.$root.$off;
	},
}
</script>

<style scoped>
.cart_btn:focus {
	outline: none;
	box-shadow: none;
}

.cart-input{
	width: 25px;
	text-align: center;
	border:none;
    background-image: none;
    background-color: transparent;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

.cc-input {
	margin-top: 1px;
	height: 22px;
	width: 22px;
}

.card {
	border: none !important;
}
</style>