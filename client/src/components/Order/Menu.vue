<template>
	<div class="my-4">
		<div v-if="menu.length === 0">
			<content-placeholders class="my-5" :rounded="true" v-for="(item, index) in placeholder" :key="index">
				<content-placeholders-heading />
			</content-placeholders>
		</div>
		<MenuItem v-else v-bind:key="coffee.code" v-for="coffee in menu" :coffee="coffee"/>
	</div>
</template>

<script>
import MenuItem from './MenuItem';
import NProgress from 'nprogress';

export default {
	name: 'Menu',

	components: {
		MenuItem
	},

	data() {
		return {
			placeholder: 5,
			menu: [],
		}
	},

	async created() {
		const token = this.$cookies.get('token');

		if (token) {
			NProgress.start();
			
			try {
				const response = await fetch('http://localhost:3000/order/coffees', {
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