<template>
	<div class="my-4">
		<MenuItem v-bind:key="coffee.code" v-for="coffee in menu" :coffee="coffee"/>
	</div>
</template>

<script>
import MenuItem from './MenuItem';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Menu',

	components: {
		MenuItem
	},

	data() {
		return {
			menu: [],
		}
	},

	async created() {
		const token = VueCookies.get('token');

		if (token) {
			try {
				let response = await fetch('http://localhost:3000/order/coffees', {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});
				
				if (response.ok) {
					const res = await response.json();

					if (res.menu) {
						this.menu = res.menu;
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

<style scoped>
.pointer {
	cursor: pointer;
}

.menu-title {
	color: rgb(22, 22, 22);
	text-decoration: none;
}

.menu-title:hover {
	color: #bb6b00;
}
</style>