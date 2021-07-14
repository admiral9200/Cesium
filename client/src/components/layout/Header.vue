<template>
	<nav class="navbar py-4 container">
		<router-link to="/" class="navbar-brand">
			<img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
		</router-link>
		<b-dropdown variant="link" toggle-class="cc-dropdown" lazy>
			<template #button-content>{{ username }} <i class='far fa-user'></i></template>
			<b-dropdown-item to="/profile">Ο λογαριασμός μου</b-dropdown-item>
			<b-dropdown-item to="/rates">Οι Αξιολογήσεις μου</b-dropdown-item>
			<b-dropdown-item to="/payments">Ηλ. Πληρωμές</b-dropdown-item>
			<b-dropdown-item to="/settings">Ρυθμίσεις</b-dropdown-item>
			<b-dropdown-divider></b-dropdown-divider>
			<b-dropdown-item v-on:click="logout">Αποσύνδεση</b-dropdown-item>
		</b-dropdown>
	</nav>
</template>

<script>
import router from '../../router';

export default {
	name: 'Header',

	computed: {
		username() {
			return this.$store.state.userInfo.name;
		}
	},

	methods: {
		logout: async function() {
			const user = this.username;
			try {	
				let response = await fetch('http://localhost:3000/auth/logout', {
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
						this.$store.state.userInfo.name = null;
						this.$store.state.userInfo.surname = null;
						this.$store.state.userInfo.mobile = null;
						this.$store.state.userInfo.email = null;
						this.$store.state.userInfo.id = null;
						this.$store.state.token = null;
						this.$store.state.userAddresses = [];
						this.$store.state.userCart = {
							products: [],
							store_id: ''
						};
						this.$cookies.remove('token');
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
}
</script>

<style>
.cc-dropdown {
	text-decoration: none !important;
	color: white !important;
	font-size: 1.2rem !important;
}

.cc-dropdown:focus {
	box-shadow: none !important;
}

.cc-dropdown:hover {
	color: #bb6b00 !important;
}
</style>