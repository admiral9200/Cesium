<template>
	<v-form v-model="valid">
		<v-container>
			<v-row>
				<v-col cols="7" md="4">
					<v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
				</v-col>
			</v-row>
		</v-container>
	</v-form>
</template>

<script>
export default {

}
</script>

<style>

</style>