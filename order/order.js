/* jshint esversion: 6 */
let getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '../php/base.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			prof = JSON.parse(this.responseText);
			document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
		}
	};
	xhr.send();
};

(() => getProfile())();

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
		var sugarTypes = document.getElementsByName("sugarType"+id);
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

var loader = document.getElementById("loader");
var blurred = document.getElementById("blurred");

function getValues(code){
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
	else{
		//$("#s"+code).
	}
}

let addCoffeeToCart = (code, sugar, sugarType, milk, cinnamon, choco) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let params = "form=" + code + "&sugar=" + sugar + "&sugarType=" + sugarType + "&milk=" + milk + "&cinnamon=" + cinnamon + "&choco=" + choco;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php", () => resetForms());
			}
			else if(this.responseText == false){
				document.getElementById('false').classList.add("mt-3");
				document.getElementById('false').innerHTML = "<div class='alert alert-danger alert-dismissible fade show'>" +
                													"<button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος. Δοκίμασε ξανά." +
              													"</div>";
				$("#cart").load("view_cart.php", () => resetForms());
			}
		}
	};
	xhr.send(params);
};

let resetForms = () => {
	$('form').each(function(){ 
		this.reset();
	});
	$('.collapse').collapse('hide');
	$('input[name*="sugarType"]' ).prop('disabled', false);
	loader.style.display = "none";
	blurred.style.display = "none";
	$('body').removeClass('stop-scrolling');
};