<template>
	<form v-on:submit.prevent="Activator">
		<div class="input-group">
			<select v-model="selected._id" class="form-select pointer-base" :disabled="UserAddresses.length === 0">
				<option
					v-for="(address, index) in UserAddresses" 
					:key="index" 
					:value="address._id">
					{{ AddressFormat(address) }}
				</option>
			</select>
			<button class="btn mainbtn" :class="{ 'disabled': UserAddresses.length === 0 }" type="submit" id="insert">Παράγγειλε</button>
		</div>
	</form>
</template>

<script>
import NProgress from 'nprogress';
import router from '../../router';

export default {
	name: "AddressSelector",

	data() {
		return {
			selected: this.$cookies.get('actaddr'),
		}
	},
	
	created() {
		if (this.UserAddresses.length > 0) {
			this.$cookies.set("actaddr", this.UserAddresses[0], Infinity);
			this.selected = this.UserAddresses[0];
		}
	},

	mounted() {
		let userAddrs = this.UserAddresses;
		this.$root.$on('CookieUpdate', function () {
			if (userAddrs.length > 0) {
				this.$cookies.set("actaddr", userAddrs[0], Infinity);
				this.selected = userAddrs[0];
			}
			else {
				this.selected = '';
			}
		});
	},

	computed: {
		UserAddresses() {
			return this.$store.state.userAddresses;
		}
	},

	methods: {
		AddressFormat: function (address) {
			return address.route + ' ' + address.street_number + ', ' + address.locality + ' ' + address.postal_code;
		},

		Activator: function() {
			NProgress.start();

			try {
				const token = this.$cookies.get('token');

				if (token) {
					this.$cookies.set("actaddr", this.UserAddresses.find(addr => addr._id === this.selected._id), Infinity);
					this.selected = this.$cookies.get('actaddr');

					router.push('/order');
				}
			}
			finally {
				NProgress.done();
			}
		}
	},
}
</script>