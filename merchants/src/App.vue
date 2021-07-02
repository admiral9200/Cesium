<template>
	<v-app>
		<v-main>
			<v-container fluid>
				<router-view></router-view>
			</v-container>
		</v-main>
	</v-app>
</template>

<script>
export default {
	name: 'App'
};
</script>

<style>
html, body {
	font-family: "Manrope", sans-serif;
}
</style>