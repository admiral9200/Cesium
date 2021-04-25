<template>
	<div class="my-4">
		<div v-bind:key="coffee.code" v-for="(coffee) in menu">
			<a type="button" class="text-dark w-100" data-bs-toggle="modal" :data-bs-target="'#coffee' + coffee.code">
				<div class="card">
					<div class="card-body p-1">
						<h6 class="card-title">{{ coffee.name }}</h6>
						<h6 class="card-subtitle text-muted">Από {{ coffee.price }}€</h6>
					</div>
				</div>
			</a>
			<div class="modal fade" :id="'coffee' + coffee.code" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-grid">
								<h5 class="modal-title">{{ coffee.name }}</h5>
								<h6 class="card-subtitle text-muted my-1">{{ coffee.price }}€</h6>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<h6>Επιλέξτε μέγεθος*</h6>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn mainbtn">Προσθήκη στο καλάθι</button>
						</div>
					</div>
				</div>
			</div>
			<hr class="my-3">
		</div>
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

export default {
	name: 'Menu',
	data() {
		return {
			menu: null
		}
	},

	mounted() {
		
	},

	async created() {
		const token = VueCookies.get('token');

		if (token) {
			try {
				let response = await fetch('http://localhost:3000/order/coffees', {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});
				
				if (response.ok) {
					const res = await response.json();

					if (res.menu) {
						this.menu = res.menu;
					}
				}
				else if (!response.ok){
					this.$notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: 'Unexpected error: ' + response.status
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
			finally {
				NProgress.done();
			}
		}
	},

	methods: {
		
	},
}
</script>

<style scoped>
.accordion svg{
	margin-top: 2px;
	font-size: 1.2rem;
}

.card {
	border: none;
	border-radius: 15px;
}

.card-header:hover {
	background-color: rgba(0, 0, 0, .08);
}

.pointer {
	cursor: pointer;
}

.menu-title {
	color: rgb(22, 22, 22);
	text-decoration: none;
}

.menu-title:hover {
	color: #bb6b00;
}
</style>