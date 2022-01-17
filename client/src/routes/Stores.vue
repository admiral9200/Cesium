<template>
	<div>
		<div class="background">
			<Header/>
			<div class="container py-3">
				<h1>Βρήκαμε {{ stores.length }} {{ stores.length === 1 ? 'κατάστημα' : 'καταστήματα' }}</h1>
			</div>
		</div>
		<div class="container">
			<OverviewCart/>
			<StoresList 
				:stores="stores" 
				:isApiStoresResolved="isApiStoresResolved" 
				:noStoresFound="noStoresFound" 
				:msg="msg"
			/>
		</div>
		<Sale/>
		<Footer/>
	</div>
</template>

<script>
import Sale from '../components/layout/Sale';
import Header from '../components/layout/Header';
import Footer from '../components/layout/Footer';
import StoresList from '../components/Stores/StoresList';
import OverviewCart from '../components/Stores/OverviewCart';
import NProgress from 'nprogress';

export default {
	name: 'Stores',

	components: {
		Header,
		Footer,
		Sale,
		StoresList,
		OverviewCart
	},

	data() {
		return {
			stores: [],
			user_addr: this.$cookies.get('actaddr'),
			isApiStoresResolved: false,
			noStoresFound: false,
			msg: ''
		}
	},

	async beforeRouteLeave (to, from, next) {
		if (to.path !== '/checkout') {
			const token = this.$cookies.get('token');

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
		}
		else {
			next();
		}
	},

	async created() {
		const token = this.$cookies.get('token');
		const userAddress = this.user_addr.route + ' ' + this.user_addr.street_number + ', ' + this.user_addr.locality + ' ' + this.user_addr.postal_code;

		if (token) {
			try {
				const response = await fetch('http://' + this.$store.state.base_url + ':3000/stores/user/' + userAddress, {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});
				
				if (response.ok) {
					const res = await response.json();

					if (res.stores) {
						this.stores = res.stores;
					}
					else if (res.noStoresFound) {
						this.isApiStoresResolved = true;
						this.noStoresFound = res.noStoresFound;
						this.msg = res.msg;
					}
					else if (res.error.name === 'UserAddressNotFound') {
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: 'Unexpected error: ' + res.error.msg
						});

						this.$router.push('/home');
					}
					else {
						this.$notify({
							group: 'errors',
							type: 'error',
							title: 'Error',
							text: 'Unexpected error: ' + res.error
						});
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
}
</script>