<template>
	<div class="card my-4">
		<div class="row">
			<div class="card-body flex-grow-0 col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-3 ms-3 d-flex justify-content-center align-items-center">
				<img :src="store.logo" class="store-img">
			</div>
			<div class="card-body flex-grow-1 col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-7">
				<h5 class="card-title mb-1">{{ store.name }}</h5>
				<p class="card-text text-muted">{{ store.location + ' - ' + 'Εκτιμώμενος χρόνος: ' + store.duration.text }}</p>
			</div>
			<div class="card-body flex-grow-0 col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-12 d-flex justify-content-center align-self-center">
				<a v-on:click="handleStoreSelection(store._id)" class="btn mainbtn">Παράγγειλε από εδώ</a>
			</div>
		</div>
	</div>
</template>

<script>
import NProgress from 'nprogress';
import router from '../../router';

export default {
	name: 'StoreItem',

	props: ['store'],

	methods: {
		handleStoreSelection: async function(id) {
			const token = this.$cookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const response = await fetch('http://' + this.$store.state.base_url + ':3000/stores/select', {
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
							this.$store.state.userCart.store_id = id;
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
	width: 70px;
}
</style>