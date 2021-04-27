<template>
	<div>
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
					<div class="modal-body bg-light">
						<h6>Επιλέξτε μέγεθος*</h6>
						<div class="row">
							<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
								<input class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label ps-2 pointer-base" for="flexCheckDefault">Default checkbox</label>
							</div>
							<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
								<input class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label ps-2 pointer-base" for="flexCheckDefault">Default checkbox</label>
							</div>
							<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
								<input class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label ps-2 pointer-base" for="flexCheckDefault">Default checkbox</label>
							</div>
						</div>
						<h6 class="mt-3">Επιλέξτε ζάχαρη*</h6>
						<div class="row">
							<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
								<input class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label ps-2 pointer-base" for="flexCheckDefault">Default checkbox</label>
							</div>
							<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
								<input class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label ps-2 pointer-base" for="flexCheckDefault">Default checkbox</label>
							</div>
							<div class="col-5 m-1 pointer user-select-none border border-white bg-white rounded-1 py-2 px-3" for="flexCheckDefault">
								<input class="form-check-input cc-input m-0 pointer-base" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label ps-2 pointer-base" for="flexCheckDefault">Default checkbox</label>
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<div class="justify-content-start w-25">
							<div class="input-group">
								<button v-on:click="quantityMinus" class="input-group-text">-</button>
								<input v-model="quantity" class="form-control ps-3" disabled>
								<button v-on:click="quantity++" class="input-group-text">+</button>
							</div>
						</div>
						<div class="justify-content-end">
							<button type="button" class="btn mainbtn">Προσθήκη στο καλάθι</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr class="my-3">
	</div>
</template>

<script>
export default {
	name: 'MenuItem',

	props: ['coffee'],

	data() {
		return {
			quantity: 1
		}
	},

	methods: {
		quantityMinus: function() {
			if (this.quantity > 1) this.quantity--;
		}
	},
}
</script>

<style scoped>
.modal-content {
	font-size: 14px;
}

.cc-input {
	margin-top: 1px;
	height: 22px;
	width: 22px;
}

.card {
	border: none;
	border-radius: 15px;
}

.card-header:hover {
	background-color: rgba(0, 0, 0, .08);
}
</style>