<template>
	<div class="my-4">
		<div v-bind:key="coffee.code" v-for="(coffee, index) in menu" class='card'>
			<div class='card-header p-0 align-middle'>
				<a @click="isAccordionExpanded = !isAccordionExpanded" class='btn btn-link p-3 menu-title w-100' :data-target="'#menu' + index" :data-toggle="'menu' + index" aria-expanded='false' :aria-controls="'menu' + index">
					<h6 class="m-0 float-left">{{ coffee.name }} {{ coffee.price }}€</h6>
					<i :class="[ isAccordionExpanded ? 'fa-minus' : 'fa-plus' , 'fa']" class="float-right"></i>
				</a>
			</div>
			<div :id="'menu' + index" class='collapse'>
				<div class='container my-3'>
					<form class="w-100">
						<div class='row user-select-none'>
							<div class='col-xl-3 col-12 mb-2'>
								<h5>Επίλεξε ζάχαρη</h5>
								<div class='custom-control custom-radio pointer pointer' onclick='uncheck(coffee_code)'>
									<input type='radio' id='scoffee_code' value='Γλυκός' name='sugarcoffee_code' class='custom-control-input'/>
									<label class='custom-control-label pointer' for='scoffee_code'>Γλυκός</label>
								</div>
								<div class='custom-control custom-radio pointer' onclick='uncheck(coffee_code)'>
									<input type='radio' id='mcoffee_code' value='Μέτριος' name='sugarcoffee_code' class='custom-control-input'/>
									<label class='custom-control-label pointer' for='mcoffee_code'>Μέτριος</label>
								</div>
								<div class='custom-control custom-radio pointer' onclick='noneSugar(coffee_code)'>
									<input type='radio' id='nocoffee_code' value='Σκέτος' name='sugarcoffee_code' class='custom-control-input'/>
									<label class='custom-control-label pointer' for='nocoffee_code'>Σκέτος</label>
								</div>
							</div>
							<div class='col-xl-4 col-12 mb-2'>
								<h5>Επίλεξε είδος ζάχαρης</h5>  
								<div class='custom-control custom-radio pointer'>
									<input type='radio' :id="'WH' + coffee.code" name='sugarTypecoffee_code' value='Λευκή ζάχαρη' class='custom-control-input pointer' data-toggle="popover">
									<label class='custom-control-label pointer' :for="'WH' + coffee.code">Λευκή ζάχαρη</label>
								</div>
								<div class='custom-control custom-radio pointer'>
									<input type='radio' id='BRcoffee_code' name='sugarTypecoffee_code' value='Καστανή ζάχαρη' class='custom-control-input pointer'>
									<label class='custom-control-label pointer' for='BRcoffee_code'>Καστανή ζάχαρη</label>
								</div>
								<div class='custom-control custom-radio pointer'>
									<input type='radio' id='BLcoffee_code' name='sugarTypecoffee_code' value='Μαύρη ζάχαρη' class='custom-control-input pointer'>
									<label class='custom-control-label pointer' for='BLcoffee_code'>Μαύρη ζάχαρη</label>
								</div>
								<div class='custom-control custom-radio pointer'>
									<input type='radio' id='SAcoffee_code' name='sugarTypecoffee_code' value='Ζαχαρίνη' class='custom-control-input pointer'>
									<label class='custom-control-label pointer' for='SAcoffee_code'>Ζαχαρίνη</label>
								</div>
							</div>
							<div v-if="coffee.choco || coffee.cinnamon || coffee.milk" class='col-xl-3 col-12 mb-2'>
								<h5>Πρόσθεσε</h5>
								<div v-if="coffee.milk" class='custom-control custom-checkbox pointer'>
									<input class='custom-control-input pointer' type='checkbox' name='milkcoffee_code' id='milk_coffee_code'>
									<label class='custom-control-label pointer' for='milk_coffee_code'>Γάλα</label>
								</div>
								<div v-if="coffee.cinnamon" class='custom-control custom-checkbox pointer'>
									<input class='custom-control-input pointer' type='checkbox' name='cinnamoncoffee_code' id='cinnamon_coffee_code'>
									<label class='custom-control-label pointer' for='cinnamon_coffee_code'>Κανέλα</label>
								</div>
								<div v-if="coffee.choco" class='custom-control custom-checkbox pointer'>
									<input class='custom-control-input pointer' type='checkbox' name='chococoffee_code' id='choco_coffee_code'>
									<label class='custom-control-label pointer' for='choco_coffee_code'>Σκόνη Σοκολάτας</label>
								</div>
							</div> 
						</div>
					</form>
					<div class='row justify-content-center mt-3'>
						<button type='button' class='btn mainbtn btn-md text-white' onclick="getValues(coffee_code , ${coffee.price})">Προσθήκη στο καλάθι</button>
					</div>
				</div>  
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Menu',
	data() {
		return {
			isAccordionExpanded: false,
			menu: []
		}
	},

	mounted() {
		
	},

	async created() {
		try {
			let response = await fetch('http://localhost:3000/order/coffees');
			
			if (response.ok) {
				this.menu = await response.json();
			}
			else if (!response.ok){
				console.log(response.status);
			}
		} 
		catch (error) {
			console.error(error)
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