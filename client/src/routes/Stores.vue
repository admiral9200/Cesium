<template>
	<div>
		<div class="background">
			<Header/>
			<div class="container py-3">
				<h1>Βρήκαμε {{ stores.length }} {{ stores.length > 1 ? 'καταστήματα' : 'κατάστημα' }}</h1>
			</div>
		</div>
		<div class="container">
			<StoresList :stores="stores"/>
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
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Stores',

	components: {
		Header,
		Footer,
		Sale,
		StoresList,
	},

	data() {
		return {
			stores: []
		}
	},

	async created() {
		const token = VueCookies.get('token');

		if (token) {
			try {
				const response = await fetch('http://localhost:3000/stores/merchants', {
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