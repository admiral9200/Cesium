$(document).ready(function(){    
	$('#addresses').load("./php/addresses.php");
});

var address = document.getElementById('address');
var state = document.getElementById('state');
var loader = document.getElementById("loader");
var blurred = document.getElementById("blurred");

address.addEventListener('keyup', function() {
	address.closest(".group").querySelector('.text-danger').style.display = 'none';
	address.classList.remove("wrong");
	if(address.value == "") {
		address.closest(".group").querySelector('.text-danger').style.display = 'block';
		address.classList.add("wrong");
	}
});

state.addEventListener('keyup', function() {
	state.closest(".group").querySelector('.text-danger').style.display = 'none';
	state.classList.remove("wrong");
	if(state.value == "") {
		state.closest(".group").querySelector('.text-danger').style.display = 'block';
		state.classList.add("wrong");
	}
});

document.getElementById('add').addEventListener('click', function addAddress(e){
	e.preventDefault();
	if(validateAddress()){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', './php/address.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "address=" + address.value + "&state=" + state.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					$("#addresses").load("./php/addresses.php");
					$("#cart_item").html("");
					$("#home").load("./php/address_menu.php");
					loader.style.display = "none";
					blurred.style.display = "none";
					$('body').removeClass('stop-scrolling');
				}
				else{
					document.getElementById('false').innerHTML = this.responseText;
					$("#addresses").load("./php/addresses.php");
					loader.style.display = "none";
					blurred.style.display = "none";
					$('body').removeClass('stop-scrolling');
				}
			}
		}
		xhr.send(params);
	}
});

function validateAddress(){
	var form = [address, state];
	var val = true;
	for(var i = 0; i < form.length; i++){
		if(form[i].value == ""){
			form[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			form[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
}