<template>
	<v-form v-model="valid">
		<v-row :align="center">
			<v-col cols="5" md="4">
				<v-text-field v-model="email" :rules="[rules.required, rules.email]" label="Email" required></v-text-field>
				<v-text-field
					v-model="password"
					:append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
					:rules="[rules.required]"
					:type="show1 ? 'text' : 'password'"
					name="input-10-1"
					label="Password"
					counter
					@click:append="show1 = !show1"
				></v-text-field>
			</v-col>
		</v-row>
	</v-form>
</template>

<script>
export default {
	data () {
		return {
			show1: false,
			show2: true,
			show3: false,
			show4: false,
			password: '',
			rules: {
				required: value => !!value || 'Required.',
			},
		}
    },
}
</script>

<style>

</style>