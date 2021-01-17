let loader = document.getElementById("loader");
let blurred = document.getElementById("blurred");

let cartProducts = {
	coffee: "Espresso",
	code: 1000,
	sugar: "Γλυκός",
	sugarType: "Μαύρη"
};

const cartHandler = () => {
	
};

(async () => {
	try {	
		let response = await fetch('order.php');
		if(response.ok){
			let coffees = await response.json();
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
																		(() => coffee.milk == 1 || coffee.cinnamon == 1 || coffee.choco == 1 ? '<h5>Πρόσθεσε</h5>' : '')()+ //HOW THE FUCK THIS WORKS XD
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
																<button type='button' class='btn mainbtn btn-md text-white' onclick="getValues(${coffee.code})">Προσθήκη στο καλάθι</button>
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
	$("#cart").load("view_cart.php");
	$('form').each(function(){
		this.reset();
	});
});

$(".collapse").on('show.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-plus fa-minus'); 
});

$(".collapse").on('hide.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-minus fa-plus'); 
});

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

const getValues = (code) =>{
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
		addCoffeeToCart (code ,sugar, sugarType, milk, cinnamon, choco);	
	}
	else if(noSugar.checked && sugarType == null){
		sugar = sugar.value;
		sugarType = "";
		milk = milk === null ? milk = 0 : milk = 1;
		cinnamon = cinnamon === null ? cinnamon = 0 : cinnamon = 1;
		choco = choco === null ? choco = 0 : choco = 1;
		addCoffeeToCart (code ,sugar, sugarType, milk, cinnamon, choco);
	}
	else{}
};

let quantity = (count, qty) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	const xhr = new XMLHttpRequest();
	xhr.open('POST', 'cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let params = "qty=" + qty + "&counter=" + count;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php", () => resetForms());
			}
			else{
				document.getElementById('false').classList.add("mt-3");
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php", () => resetForms());
			}
		}
	}
	xhr.send(params);
};

let deleteCoffee = (code) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	const xhr = new XMLHttpRequest();
	xhr.open('POST', 'cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let params = "count=" + code;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php", () => resetForms());
			}
			else{
				document.getElementById('false').classList.add("mt-3");
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php", () => resetForms());
			}
		}
	}
	xhr.send(params);
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