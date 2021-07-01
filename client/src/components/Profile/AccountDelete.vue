<template>
	<div>
		<div class="form-group row mt-4">
			<div class="col-12">
				<b-button v-b-modal.accountDelete type="button" class="btn btn-block btn-danger">Διαγραφή Λογαριασμού</b-button>
			</div>
		</div>
		<b-modal class="modal fade" id="accountDelete" title="Οριστική Διαγραφή Λογαριασμού" @ok="deleteAccount" ok-variant="danger" ok-title="Συνέχεια" cancel-title="Ακύρωση">
			<template>
				Η διαγραφή του λογαριασμού σου είναι οριστική και θα διαγραφούν όλα τα δεδομένα σου στο Cofy. Είσαι σίγουρος ότι θες να συνεχίσεις;
			</template>
		</b-modal>
	</div>
</template>

<script>
import router from '../../router';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'AccountDelete',

	methods: {
		deleteAccount: async function() {
			NProgress.start();
			const token = VueCookies.get('token');

			if (token) {
				try {
					let response = await fetch('http://localhost:3000/profile/delete', {
						method: 'GET',
						headers: {
							"Content-type" : "application/json; charset=UTF-8",
							"Authorization" : token,
						}
					});

					if (response.ok) {
						let res = await response.json();

						if (res.deleted) {
							this.$store.state.userInfo.name = null;
							this.$store.state.userInfo.surname = null;
							this.$store.state.userInfo.mobile = null;
							this.$store.state.userInfo.email = null;
							this.$store.state.token = null;
							this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie));
							router.push("/");
						}
						else if (res.error){
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: res.error
							});
						}
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
		}
	},
}
</script>

<style>

</style>