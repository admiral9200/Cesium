<template>
	<form v-on:submit.prevent="addAddress" class="mx-xl-5 mx-lg-5">
		<div class="input-group">
			<vue-google-autocomplete
				ref="address"
				id="ba021a1a9d298ee2"
				classname="form-control test"
				placeholder="Πρόσθεσε εδώ την διεύθυνσή σου"
				v-on:placechanged="getAddressData"
				:country="['gr']"
				:enable-geolocation=true
				v-model.trim="$v.address.$model" :class="{ 'error': $v.address.$error }"
			></vue-google-autocomplete>
			<button class="btn mainbtn" type="submit" id="insert">Προσθήκη</button>
		</div>
		<div v-if="!$v.address.required && $v.address.$dirty" class="text-danger">Πρέπει να συμπληρώσεις μία διεύθυνση</div>
	</form>
</template>

<script>
import NProgress from 'nprogress';
import { required } from 'vuelidate/lib/validators';
import VueGoogleAutocomplete from 'vue-google-autocomplete';

export default {
	name: "InsertAddress",

	components: {
		VueGoogleAutocomplete
	},

	validations: {
		address: {
			required
		}
	},

	computed: {
		UserAddresses() {
			return this.$store.state.userAddresses;
		}
	},

	data() {
		return {
			address: null
		}
	},

	mounted() {
		this.$refs.address.clear();
	},

	methods: {
		getAddressData: function (addressData) {
			this.address = addressData;
        },

		isAddressVerifiedObject: function(item) {
			try {	
				return 'route' in item &&
					'longitude' in item &&
					'latitude' in item &&
					'country' in item &&
					'locality' in item;
			} 
			catch (error) {
				return false;
			}
		},

		addAddress: async function() {
			if (this.$refs.address.autocompleteText && this.isAddressVerifiedObject(this.address)) {
				NProgress.start();
				try {
					const token = this.$cookies.get('token');

					let response = await fetch('http://' + this.$store.state.base_url + ':3000/home/address', {
						method: 'POST',
						body: JSON.stringify({
							address: this.address
						}),
						headers: {
							"Authorization" : token,
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (response.ok) {
						const res = await response.json();

						if (res.completed === true) {
							this.$root.$emit('CookieUpdate');
							this.$root.$emit('InsertAddressResolved');
							
							this.$notify({
								group: 'errors',
								type: 'success',
								title: 'Ειδοποίηση',
								text: 'Η διεύθυνση προστέθηκε.'
							});

							this.$root.$emit('fetchAdresses');
							this.$refs.address.clear();
							this.address = null;
						}
						else if (res.error) {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: res.error
							});
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: 'An unexpected error occured'
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
}
</script>

<style>
.pac-container {
	border: none !important;
	z-index: 1700;
}
</style>