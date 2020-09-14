var address = document.getElementById('address');
var state = document.getElementById('state');
var loader = document.getElementById("loader");
var blurred = document.getElementById("blurred");

document.getElementById('add').addEventListener('click', addAddress);

address.addEventListener('keyup', function(e){
	address.closest(".group").querySelector('.text-danger').style.display = 'none';
	address.classList.remove("wrong");
	if(address.value == "") {
		address.closest(".group").querySelector('.text-danger').style.display = 'block';
		address.classList.add("wrong");
	}
	if (e.keyCode === 13 || e.key === 13) addAddress();
});

state.addEventListener('keyup', function(e){
	state.closest(".group").querySelector('.text-danger').style.display = 'none';
	state.classList.remove("wrong");
	if(state.value == "") {
		state.closest(".group").querySelector('.text-danger').style.display = 'block';
		state.classList.add("wrong");
	}
	if (e.keyCode === 13 || e.key === 13) addAddress();
});

function addAddress(){
	if(validateAddress()){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'address.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "address=" + address.value + "&state=" + state.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					$("#addresses").load("addresses.php");
					$("#home").load("address_menu.php");
					loader.style.display = "none";
					blurred.style.display = "none";
					$('body').removeClass('stop-scrolling');
				}
				else{
					document.getElementById('false').innerHTML = this.responseText;
					$("#addresses").load("addresses.php");
					loader.style.display = "none";
					blurred.style.display = "none";
					$('body').removeClass('stop-scrolling');
				}
			}
		}
		xhr.send(params);
	}
}

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