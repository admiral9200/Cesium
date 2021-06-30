<template>
	<div class="card my-4">
		<div class="d-flex">
			<div class="card-body flex-grow-0">
				<img :src="store.logo" class="store-img">
			</div>
			<div class="card-body flex-grow-1">
				<h5 class="card-title mb-1">{{ store.name }}</h5>
				<p class="card-text text-muted">{{ store.location + ' - ' + 'Εκτιμώμενος χρόνος: ' + store.duration.text }}</p>
			</div>
			<div class="card-body flex-grow-0 d-flex justify-content-center align-self-center">
				<a v-on:click="handleStoreSelection(store._id)" class="btn mainbtn">Παράγγειλε από εδώ</a>
			</div>
		</div>
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';
import router from '../../router';

export default {
	name: 'StoreItem',

	props: ['store'],

	methods: {
		handleStoreSelection: async function(id) {
			const token = VueCookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const response = await fetch('http://localhost:3000/stores/select', {
						method: 'POST',
						headers: {
							"Content-type" : "application/json; charset=UTF-8",	
							"Authorization" : token,
						},
						body: JSON.stringify({
							user_id: this.$store.state.userInfo.id,
							store_id: id
						})
					});
					
					if (response.ok) {
						const res = await response.json();

						if (res.ok) {
							router.push('/checkout');
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Chip Coffee',
								text: res.error
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
					NProgress.inc();
				}
			}
		}
	},
}
</script>

<style scoped>
.store-img {
	width: 60px;
}
</style>