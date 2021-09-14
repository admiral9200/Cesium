<template>
	<v-app>
		<notifications group="errors"/>

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
			<v-menu left bottom>
				<template v-slot:activator="{ on, attrs }">
					<v-btn icon v-bind="attrs" v-on="on">
						<v-icon>mdi-dots-vertical</v-icon>
					</v-btn>
				</template>
				<v-list>
					<v-list-item @click="() => {}">
						<v-list-item-title>Settings</v-list-item-title>
					</v-list-item>
					<v-list-item @click="logout">
						<v-list-item-title>Logout</v-list-item-title>
					</v-list-item>
				</v-list>
			</v-menu>
		</v-app-bar>

		<div v-if="LoggedIn">
			<v-main>
				<v-container fluid>
					<router-view></router-view>
				</v-container>
			</v-main>
		</div>
		<section v-else class="d-flex flex-column justify-center align-center align-self-stretch flex-grow-1">
			<router-view></router-view>
		</section>
	</v-app>
</template>

<script>
import router from '@/router/index';

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
	},

	methods: {
		logout: async function() {
			const user = this.username;
			try {	
				let response = await fetch('http://' + this.$store.state.base_url + ':3000/m/auth/logout', {
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
						this.$store.state.user = {
							id: '',
							email: '',
							username: ''
						};

						this.$cookies.remove('cc_b_id');

						this.$store.state.loggedIn = false;

						router.push("/");
					}
				}
				else {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: response.status
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
		}
	},
};
</script>

<style>
html, body {
	font-family: "Manrope", sans-serif;
}
</style>