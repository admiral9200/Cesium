<template>
	<v-app>
		<notifications position="top center" class="ma-2 user-select-none" group="main"/>

		<v-navigation-drawer app v-if="LoggedIn">
			<v-list-item>
				<v-list-item-content>
					<v-list-item-title class="text-h6">Cofy Merchants</v-list-item-title>
					<v-list-item-subtitle>All rights reserved</v-list-item-subtitle>
				</v-list-item-content>
			</v-list-item>

			<v-divider></v-divider>

			<v-list dense nav class="mt-5">
				<v-list-item v-for="item in items" :key="item.title" :to="item.path" link>
					<v-list-item-icon>
						<v-icon>{{ item.icon }}</v-icon>
					</v-list-item-icon>
					<v-list-item-content>
						<v-list-item-title>{{ item.title }}</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-navigation-drawer>

		<v-app-bar app flat v-if="LoggedIn">
			<v-img
				max-height="50"
				max-width="50"
				:src="Merchant.logo"
				class="ma-2"
			></v-img>
			<v-toolbar-title>{{ Merchant.name }}</v-toolbar-title>

			<v-spacer></v-spacer>

			<v-switch flat v-model="StoreStatus" :label="StoreStatus ? 'Store Online' : 'Store Offline'" color="success" class="mt-6 mr-4"></v-switch>

			<v-menu left bottom>
				<template v-slot:activator="{ on, attrs }">
					<v-btn icon v-bind="attrs" v-on="on">
						<v-icon>mdi-dots-vertical</v-icon>
					</v-btn>
				</template>
				<v-list>
					<v-list-item to="/settings">
						<v-list-item-title>Settings</v-list-item-title>
					</v-list-item>
					<v-list-item @click="logout">
						<v-list-item-title>Logout</v-list-item-title>
					</v-list-item>
				</v-list>
			</v-menu>
		</v-app-bar>

		<v-main v-if="LoggedIn">
			<v-container fluid>
				<router-view></router-view>
			</v-container>
		</v-main>
		<main v-else class="d-flex flex-column justify-center align-center align-self-stretch flex-grow-1">
			<router-view></router-view>
		</main>
	</v-app>
</template>

<script>
import router from '@/router/index';
import NProgress from 'nprogress';

export default {
	name: 'App',

	data() {
		return {
			items: [
				{ 
					title: 'Dashboard', 
					icon: 'mdi-view-dashboard',
					path: '/home'
				},
				{ 
					title: 'Realtime Orders', 
					icon: 'mdi-access-point',
					path: '/liveorders'
				},
				{ 
					title: 'Orders', 
					icon: 'mdi-checkbox-marked-circle',
					path: '/orders'
				},
				{ 
					title: 'Payments', 
					icon: 'mdi-credit-card',
					path: '/payments'
				},
			],
		}
	},

	computed: {
		LoggedIn() {
			return this.$store.state.loggedIn;
		},

		Merchant() {
			return this.$store.state.user || {};
		},

		StoreStatus: {
			get() {
				return this.$store.state.user.store_status;
			},

			async set() {
				NProgress.start();

				try {
					const res = await fetch('http://' + this.$store.state.base_url + ':3000/m/store/status', {
						method: 'POST',
						body: JSON.stringify({
							store_status: this.$store.state.user.store_status
						}),
						headers: {
							"Authorization" : this.$cookies.get('cc_b_id'),
							"Content-type" : "application/json; charset=UTF-8"
						}
					});

					if (res.ok) {
						let response = await res.json();

						if (response.tokenExpired) {
							this.TokenExpiredHelper();

							this.$notify({
								group: 'main',
								type: 'error',
								title: 'Cofy',
								text: response.message
							});
						}

						if (response.status_changed) {
							this.$store.state.user.store_status = response.store_status;

							response.store_status ?
							this.$notify({
								group: 'main',
								type: 'success',
								title: 'Cofy',
								text: 'Your store is now online to accept orders.'
							})
							:
							this.$notify({
								group: 'main',
								type: 'warning',
								title: 'Cofy',
								text: 'Your store is now offline.'
							});
						}
						else if (response.error) {
							this.$notify({
								group: 'main',
								type: 'error',
								title: 'Cofy',
								text: response.error.msg
							});
						}
					}
				} 
				catch (error) {
					this.$notify({
						group: 'main',
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

	methods: {
		logout: async function() {
			const user = this.$store.state.user._id;

			try {	
				const response = await fetch('http://' + this.$store.state.base_url + ':3000/m/auth/logout', {
					method: 'POST',
					body: JSON.stringify({
						user
					}),
					headers: {
						"Content-type" : "application/json; charset=UTF-8"
					}
				});

				if (response.ok) {
					let res = await response.json();

					if (res.auth === false) {
						this.$store.state.user = {};
						this.$cookies.remove('cc_b_id');
						this.$store.state.loggedIn = false;
						router.push("/");
					}
				}
				else {
					this.$notify({
						group: 'main',
						type: 'error',
						title: 'Error',
						text: response.status
					});
				}
			} 
			catch (error) {
				this.$notify({
					group: 'main',
					type: 'error',
					title: 'Error',
					text: error
				});
			}
		}
	},
};
</script>

<style>
html, body {
	font-family: "Manrope", sans-serif;
}
</style>