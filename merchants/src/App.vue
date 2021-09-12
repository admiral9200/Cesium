<template>
	<v-app>
		<v-navigation-drawer app v-if="loggedIn">
		</v-navigation-drawer>

		<v-app-bar app v-if="loggedIn">
		</v-app-bar>

		<v-main class="d-flex flex-grow-1">
			<router-view></router-view>
		</v-main>
	</v-app>
</template>

<script>
export default {
	name: 'App',

	data() {
		return {
			loggedIn: false
		}
	},
};
</script>

<style>
html, body {
	font-family: "Manrope", sans-serif;
}
</style>