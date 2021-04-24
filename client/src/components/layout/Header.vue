<template>
	<nav class="navbar navbar-light container">
		<router-link to="/home" class="navbar-brand">
			<img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
		</router-link>
		<div class="dropdown">
			<a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ username }} <i class='far fa-user'></i></a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
				<router-link to="/profile" class="dropdown-item">Ο λογαριασμός μου</router-link>
				<div class="dropdown-divider"></div>
				<a v-on:click="logout" class="anchor-cursor dropdown-item">Αποσύνδεση</a>
			</div>
		</div>
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
						this.$store.state.token = null;
						this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie));
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

<style scoped>
.anchor-cursor {
	cursor: pointer;
}
</style>