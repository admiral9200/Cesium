<template>
	<form v-on:submit.prevent="changeUserInfo()">
		<div class="form-group row mb-0">
			<div class="col-xl-5 col-12">
				<label class="col-xl-5 col-form-label form-control-label pl-0">Όνομα</label>
				<input v-model="formName" :class="{ 'wrong' : !formName}" class="form-control"/>
				<div v-if="!formName" class="text-danger">Πρέπει να συμπληρώσεις ένα όνομα</div>
			</div>
			<div class="col-xl-5 col-12">
				<label class="col-xl-5 col-form-label form-control-label pl-0" autocomplete="off">Επώνυμο</label>
				<input v-model="formSurname" :class="{ 'wrong' : !formSurname}" class="form-control" type="text"/>
				<div v-if="!formSurname" class="text-danger">Πρέπει να συμπληρώσεις ένα επίθετο</div>
			</div>
		</div>
		<div class="form-group row mt-4 mb-0">
			<label class="col-xl-5 col-form-label form-control-label pl-3">Email</label>
		</div>
		<div class="form-group row">
			<div class="col-xl-5 mb-0">
				<input v-model="formEmail" class="form-control" type="email" disabled/>
			</div>
		</div>
		<div class="form-group row mt-4 mb-0">
			<label class="col-5 col-form-label form-control-label pl-3">Κινητό</label>
		</div>
		<div class="form-group row">
			<div class="col-5 mb-0">
				<input class="form-control" :class="{ 'wrong' : !formMobile}" type="text" v-model="formMobile"/>
				<div v-if="!formMobile" class="text-danger">Πρέπει να συμπληρώσεις το κινητό σου</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-12 mt-4 text-left">
				<button type="submit" class="btn btn-lg btn-block mainbtn">Αποθήκευση Αλλαγών</button>
			</div>
		</div>
	</form>
</template>

<script>
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'FormUserInfo',

	props: ['name', 'surname', 'mobile', 'email'],

	data() {
		return {
			formName: this.name,
			formSurname: this.surname,
			formMobile: this.mobile,
			formEmail: this.email,
		}
	},

	methods: {
		changeUserInfo: async function() {
			NProgress.start();
			const token = VueCookies.get('token');
			const name = this.formName;
			const surname = this.formSurname;
			const mobile = this.formMobile;

			try {	
				let response = await fetch('http://localhost:3000/profile/info', {
					method: 'POST',
					body: JSON.stringify({
						name,
						surname,
						mobile
					}),
					headers: {
						"Content-type" : "application/json; charset=UTF-8",
						"Authorization" : token,
					}
				});

				if (response.ok) {
					let res = await response.json();

					if (res.completed) {
						this.$store.state.userInfo.name = name;
						this.$store.state.userInfo.surname = surname;
						this.$store.state.userInfo.mobile = mobile;
						this.$notify({
                            group: 'errors',
                            type: 'success',
                            title: 'Cofy',
                            text: 'Τα στοιχεία σου άλλαξαν με επιτυχία'
                        });
						NProgress.done();
					}
				}
				else {
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: response.status
					});
					NProgress.done();
				}
			} 
			catch (error) {
				this.$notify({
					group: 'errors',
					type: 'error',
					title: 'Error',
					text: error
				});
				NProgress.done();
			}
		},
	},
}
</script>

<style>

</style>