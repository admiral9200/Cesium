let loader = document.getElementById("loader");
let blurred = document.getElementById("blurred");
let coffees;

const cartHandler = () => {
	let total = 0;
	let cartContent = `<h3 class='mt-3 mb-3'>Το καλάθι σου</h3>
							<ul class='list-group list-group-flush list'>`;

	if (localStorage.length > 0){

		let keys = Object.keys(localStorage);
		keys = keys.map(key => parseInt(key)).sort((a, b) => a - b);

		for (let i = 0; i < localStorage.length; i++) {

			let coffeeInCart = localStorage.getItem(keys[i]);
			coffeeInCart = JSON.parse(coffeeInCart);

			try {

				let price = coffeeInCart.price;

				cartContent += `<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
									<h5>${coffeeInCart.name}</h5>
									<a onclick="deleteCoffee(${keys[i]})" type='button' class='btn btn-sm btn-outline-danger mr-2' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></a>
								</li>
								<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 pt-0 mt-0'>
									<p class='attr'>
										${coffeeInCart.sugar}
										${coffeeInCart.sugarType !== '' ? ', ' + coffeeInCart.sugarType : ''}
										${coffeeInCart.milk === 1 ? ', Γάλα' : ''}
										${coffeeInCart.cinnamon === 1 ? ', Κανέλα' : ''}
										${coffeeInCart.choco === 1 ? ', Σκόνη Σοκολάτας' : ''}
									</p>
								</li>
								<li>
									<div class='row d-flex justify-content-center user-select-none'>
										<div class='col-4 d-flex justify-content-center mt-3'>
											<h5>${price.toFixed(2)}€</h5>
										</div>
										<div class='col-8'>
											<div class='qty d-flex justify-content-center mt-2'>
												<a type='button' class='minus' onclick="quantityHelper(${keys[i]}, 'minus')" id="minus">-</a>
												<input type='number' class='count' name='qty' value="${coffeeInCart.qty}" disabled>
												<a type='button' class='plus' onclick="quantityHelper(${keys[i]}, 'plus')" id="plus">+</a>
											</div>
										</div>
									</div>
								</li>`;

				total += coffeeInCart.price;

			} 
			catch (err) {
				console.error(err);
				break;
			}
		}
	}
	else{
		cartContent += `<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-1'>
							<h6>Το καλάθι σου είναι άδειο</h6>
						</li>`;	
	}
	cartContent += `<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 mt-5">
						<h5 class="m-0">Συνολικό Κόστος</h5>
						<h5 class="m-0">${total.toFixed(2)}€</h5>
					</li>
					</ul>
					<button type="button" name="continue" class="btn mainbtn text-white btn-block btn-lg" onclick="CheckoutHelper(${localStorage.length})" ${localStorage.length > 0 ? '' : 'disabled style="cursor: not-allowed;"'}>Συνέχεια</button>`
	$("#cart").html(cartContent);
};

(
	cartHandler(),
	async () => {
	try {	
		let response = await fetch('order.php?coffees');
		if(response.ok){
			coffees = await response.json();
			if (coffees.length > 0) {
				coffees.forEach((coffee, i) => {		
					$("#coffeesCatalog").append(`<div class='card'>
													<div class='card-header p-0 align-middle' id='heading${i}'>
														<a class='btn btn-link p-3' data-toggle='collapse' data-target='#collapse${i}' aria-expanded='false' aria-controls='collapse${i}'>${coffee.name + ' ' + coffee.price}€ <i class="fas fa-plus float-right"></i></a>
													</div>
													<div id='collapse${i}' class='collapse' aria-labelledby='heading${i}'>
														<div class='container my-3'>
															<form class="w-100">
																<div class='row'>
																	<div class='col-xl-3 col-12 mb-2'>
																		<h5>Επίλεξε ζάχαρη</h5>
																		<div class='custom-control custom-radio cursor' onclick='uncheck(${coffee.code})'>
																			<input type='radio' id='s${coffee.code}' value='Γλυκός' name='sugar${coffee.code}' class='custom-control-input'/>
																			<label class='custom-control-label cursor' for='s${coffee.code}'>Γλυκός</label>
																		</div>
																		<div class='custom-control custom-radio cursor' onclick='uncheck(${coffee.code})'>
																			<input type='radio' id='m${coffee.code}' value='Μέτριος' name='sugar${coffee.code}' class='custom-control-input'/>
																			<label class='custom-control-label cursor' for='m${coffee.code}'>Μέτριος</label>
																		</div>
																		<div class='custom-control custom-radio cursor' onclick='noneSugar(${coffee.code})'>
																			<input type='radio' id='no${coffee.code}' value='Σκέτος' name='sugar${coffee.code}' class='custom-control-input'/>
																			<label class='custom-control-label cursor' for='no${coffee.code}'>Σκέτος</label>
																		</div>
																	</div>
																	<div class='col-xl-4 col-12 mb-2'>
																		<h5>Επίλεξε είδος ζάχαρης</h5>  
																		<div class='custom-control custom-radio cursor'>
																			<input type='radio' id='WH${coffee.code}' name='sugarType${coffee.code}' value='Λευκή ζάχαρη' class='custom-control-input cursor' data-toggle="popover">
																			<label class='custom-control-label cursor' for='WH${coffee.code}'>Λευκή ζάχαρη</label>
																		</div>
																		<div class='custom-control custom-radio cursor'>
																			<input type='radio' id='BR${coffee.code}' name='sugarType${coffee.code}' value='Καστανή ζάχαρη' class='custom-control-input cursor'>
																			<label class='custom-control-label cursor' for='BR${coffee.code}'>Καστανή ζάχαρη</label>
																		</div>
																		<div class='custom-control custom-radio cursor'>
																			<input type='radio' id='BL${coffee.code}' name='sugarType${coffee.code}' value='Μαύρη ζάχαρη' class='custom-control-input cursor'>
																			<label class='custom-control-label cursor' for='BL${coffee.code}'>Μαύρη ζάχαρη</label>
																		</div>
																		<div class='custom-control custom-radio cursor'>
																			<input type='radio' id='SA${coffee.code}' name='sugarType${coffee.code}' value='Ζαχαρίνη' class='custom-control-input cursor'>
																			<label class='custom-control-label cursor' for='SA${coffee.code}'>Ζαχαρίνη</label>
																		</div>
																	</div>
																	<div class='col-xl-3 col-12 mb-2'>
																		${
																		(() => coffee.milk == 1 || coffee.cinnamon == 1 || coffee.choco == 1 ? '<h5>Πρόσθεσε</h5>' : '')()+
																		(() => coffee.milk == 1 ? `<div class='custom-control custom-checkbox cursor'>
																										<input class='custom-control-input cursor' type='checkbox' name='milk${coffee.code}' id='milk_${coffee.code}'>
																										<label class='custom-control-label cursor' for='milk_${coffee.code}'>Γάλα</label>
																									</div>` : '')()+
																		(() => coffee.cinnamon == 1 ? `<div class='custom-control custom-checkbox cursor'>
																											<input class='custom-control-input cursor' type='checkbox' name='cinnamon${coffee.code}' id='cinnamon_${coffee.code}'>
																											<label class='custom-control-label cursor' for='cinnamon_${coffee.code}'>Κανέλα</label>
																										</div>` : '')()+
																		(() => coffee.choco == 1 ? `<div class='custom-control custom-checkbox cursor'>
																										<input class='custom-control-input cursor' type='checkbox' name='choco${coffee.code}' id='choco_${coffee.code}'>
																										<label class='custom-control-label cursor' for='choco_${coffee.code}'>Σκόνη Σοκολάτας</label>
																									</div>` : '')()
																		}
																	</div> 
																</div>
															</form>
															<div class='row justify-content-center mt-3'>
																<button type='button' class='btn mainbtn btn-md text-white' onclick="getValues(${coffee.code} , ${coffee.price})">Προσθήκη στο καλάθι</button>
															</div>
														</div>  
													</div>
												</div>`);
				});
			}
			else {
				
			}
		}
		else if(!response.ok){
			$('#info').html(`<h3 class='m-5 text-center'>ERROR ${response.status}: Could not fetch orders from database. Try refreshing the page or refer the error to web masters</h3>`);
			throw new Error(response.status);
		}
	} 
	catch (error) {
		$('#info').html(`<h3 class='m-5 text-center'>${error}: Try refreshing the page or refer the error to web masters</h3>`);
	}
})();

$(document).ready(function () {
	$('form').each(function(){
		this.reset();
	});

	$(".collapse").on('show.bs.collapse', function(){
		$(this).prev('.card-header').find('svg').toggleClass('fa-plus fa-minus'); 
		console.log("adsadasdddsasdaasd");
	});
	
	$(".collapse").on('hide.bs.collapse', function(){
		console.log("adsadasdddsasdaasd");
		$(this).prev('.card-header').find('svg').toggleClass('fa-minus fa-plus'); 
	});

});

let CheckoutHelper = (cartCounter) => {
	if (cartCounter > 0) {
		location.href = '/checkout/';	
	}
};

let noneSugar = (id) => {
	document.getElementById("no"+id).onclick = function(){
		let sugarTypes = document.getElementsByName("sugarType"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = true;
			sugarTypes[i].checked = false;
		}
	};
};

let uncheck = (id) => {
	document.getElementById("s"+id).onclick = function(){
		let sugarTypes = document.getElementsByName("sugarType"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = false;
		}
	};
	document.getElementById("m"+id).onclick = function(){
		let sugarTypes = document.getElementsByName("sugarType"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = false;
		}
	};
};

const getValues = (code, price) =>{

	let noSugar = document.getElementById('no'+code);
	let sugar = document.querySelector('input[name="sugar'+code+'"]:checked');
	let sugarType = document.querySelector('input[name="sugarType'+code+'"]:checked');
	let milk = document.querySelector('input[name="milk'+code+'"]:checked');
	let cinnamon = document.querySelector('input[name="cinnamon'+code+'"]:checked');
	let choco = document.querySelector('input[name="choco'+code+'"]:checked');

	if (sugar !== null && sugarType !== null){
		sugar = sugar.value;
		sugarType = sugarType.value;
		milk = milk === null ? milk = 0 : milk = 1;
		cinnamon = cinnamon === null ? cinnamon = 0 : cinnamon = 1;
		choco = choco === null ? choco = 0 : choco = 1;
		addCoffeeToCart (code, price ,sugar, sugarType, milk, cinnamon, choco);
	}
	else if(noSugar.checked && sugarType == null){
		sugar = sugar.value;
		sugarType = "";
		milk = milk === null ? milk = 0 : milk = 1;
		cinnamon = cinnamon === null ? cinnamon = 0 : cinnamon = 1;
		choco = choco === null ? choco = 0 : choco = 1;
		addCoffeeToCart (code, price ,sugar, sugarType, milk, cinnamon, choco);
	}
	else{

	}
};

const addCoffeeToCart = (code, price, sugar, sugarType, milk, cinnamon, choco) => {

	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');

	let coffee = {
		code,
		name: coffees.find(coffee => coffee.code == code).name,
		sugar,
		sugarType,
		milk,
		cinnamon,
		choco,
		basePrice: price,
		price,
		qty: 1
	};

	let counter = localStorage.length;

	try {
		if (counter > 0) {
			let keys = Object.keys(localStorage);
			keys = keys.map(key => parseInt(key)).sort((a, b) => a - b);
	
			for (let i = 0; i < localStorage.length; i++) {
				let coffeeInCart = localStorage.getItem(keys[i]);
				coffeeInCart = JSON.parse(coffeeInCart);
	
				// for duplicate coffees increase quantity and replace with same keys
				if (coffee.code === coffeeInCart.code && coffee.sugar === coffeeInCart.sugar && coffee.sugarType === coffeeInCart.sugarType && coffee.milk === coffeeInCart.milk && coffee.cinnamon === coffeeInCart.cinnamon && coffee.choco === coffeeInCart.choco) {
					coffeeInCart.qty++;
					coffeeInCart.price = coffee.basePrice * coffeeInCart.qty;
					localStorage.setItem(keys[i], JSON.stringify(coffeeInCart));
				}
				else{
					localStorage.setItem(counter, JSON.stringify(coffee));
					break;
				}
			}
		}
		else {
			localStorage.setItem(counter, JSON.stringify(coffee));
		}	
	} 
	catch (error) {
		console.error(error);
	}
	finally {
		cartHandler();
		resetForms();
	}
};

let quantityHelper = (pos, qty) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	
	let keys = Object.keys(localStorage);

	for (let i = 0; i <= localStorage.length; i++){

		let coffee = localStorage.getItem(keys[i]);
		coffee = JSON.parse(coffee);
		
		try {
			
			if (parseInt(keys[i]) === pos) {

				if (qty === 'plus') {
					coffee.qty++;
					coffee.price = coffee.basePrice * coffee.qty;
					localStorage.setItem(keys[i], JSON.stringify(coffee));
				}
				else if (qty === 'minus' && coffee.qty > 1){
					coffee.qty--;
					coffee.price = coffee.basePrice * coffee.qty;
					localStorage.setItem(keys[i], JSON.stringify(coffee));
				}

			}
		} 
		catch (error) {
			console.error(error);
		}
	}

	cartHandler();
	resetForms();
};

let deleteCoffee = (pos) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	
	let keys = Object.keys(localStorage);

	for (let i = 0; i <= localStorage.length; i++){
		let deleted = localStorage.getItem(keys[i]);

		try {
			deleted = JSON.parse(deleted);

			if (keys[i] == pos) localStorage.removeItem(keys[i]);
		} 
		catch (error) {
			
		}
	}

	cartHandler();
	resetForms();
};

const resetForms = () => {
	$('form').each(function(){ 
		this.reset();
	});
	$('.collapse').collapse('hide');
	$('input[name*="sugarType"]' ).prop('disabled', false);
	loader.style.display = "none";
	blurred.style.display = "none";
	$('body').removeClass('stop-scrolling');
};