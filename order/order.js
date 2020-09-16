$(document).ready(function () {
	$('form').each(function() { this.reset() });
	$("#cart").load("view_cart.php");
});

$(function () {
	$('[data-toggle="popover"]').popover();
});

$("#cart").load("view_cart.php");

$(".collapse").on('show.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-plus fa-minus'); 
});
$(".collapse").on('hide.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-minus fa-plus'); 
});

function noneSugar(id){
	document.getElementById("no"+id).onclick = function(){
		var sugarTypes = document.getElementsByName("sugarType"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = true;
			sugarTypes[i].checked = false;
		}
	}
}

function uncheck(id){
	document.getElementById("s"+id).onclick = function(){
		var sugarTypes = document.getElementsByName("sugarType"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = false;
		}
	}
	document.getElementById("m"+id).onclick = function(){
		var sugarTypes = document.getElementsByName("sugarType"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = false;
		}
	}
}

var loader = document.getElementById("loader");
var blurred = document.getElementById("blurred");

function getValues(code){
	var sugar = document.querySelector('input[name="sugar'+code+'"]:checked');
	var sugarType = document.querySelector('input[name="sugarType'+code+'"]:checked');
	var milk = document.querySelector('input[name="milk'+code+'"]:checked');
	var cinnamon = document.querySelector('input[name="cinnamon'+code+'"]:checked');
	var choco = document.querySelector('input[name="choco'+code+'"]:checked');
	if (sugar !== null && sugarType !== null) {
		var milk = milk === null ? milk = 0 : milk = 1;
		var cinnamon = cinnamon === null ? cinnamon = 0 : cinnamon = 1;
		var choco = choco === null ? choco = 0 : choco = 1;
		addCoffeeToCart(code ,sugar, sugarType, milk, cinnamon, choco);	
	}
	else{
		$("#s"+code).popover({
			content: 'Δεν έχεις επιλέξει ζάχαρη',
			placement: 'right',
			animation: true,
			trigger: 'focus'
		});
	}
}

function addCoffeeToCart(form, sugar, sugarType, milk, cinnamon, choco){
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../php/cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "form=" + form + "&sugar=" + sugar + "&sugarType=" + sugarType + "&milk=" + milk + "&cinnamon=" + cinnamon + "&choco=" + choco;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
			else if(this.responseText == false){
				document.getElementById('false').innerHTML = "<div class='alert alert-danger alert-dismissible fade show'>" +
                													"<button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος. Δοκίμασε ξανά." +
              													"</div>";
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
		}
	}
	xhr.send(params);
}