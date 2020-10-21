let getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '../php/functions.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			prof = JSON.parse(this.responseText);
			document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
		}
	};
	xhr.send();
};

(() => getProfile())();

let doorname = document.getElementById('doorname');
let floor = document.getElementById('floor');
let loader = document.getElementById("loader");
let blurred = document.getElementById("blurred");

document.getElementById('checkout').addEventListener('click', function(){
	if (isValidatedCheckout()){
		let submit = this.value;
		let payment = document.querySelector('input[name="payment"]:checked');
		let phone = document.getElementById('phone').value;
		let comment = document.getElementById('comment').value;
		if (submit && doorname.value && floor.value && payment.value) {
			sendOrder(submit, doorname.value, floor.value, phone, comment, payment.value);
		}
	}
});

let input = [doorname, floor];
for(let i = 0; i < input.length; i++){
	input[i].addEventListener('keyup', function(){
		this.closest(".group").querySelector('.text-danger').style.display = 'none';
		this.classList.remove("wrong");
		if (this.value == '') {
			this.closest(".group").querySelector('.text-danger').style.display = 'block';
			this.classList.add("wrong");
			document.getElementById('resReg').innerHTML = "";
		}
	});
}

let isValidatedCheckout = () => {
	let val = true;
	let orderAttr = [doorname, floor];
	let payment = document.querySelectorAll('input[name="payment"]:checked');
	if (Object.keys(payment).length === 0){
		document.getElementById('payment').style.display = 'block';
		$("label[class='form-check-label'").addClass("wrong");
		val = false;
	}
	for(let i = 0; i < orderAttr.length; i++){
		if(orderAttr[i].value == ""){
			orderAttr[i].closest("div").querySelector('.text-danger').style.display = 'block';
			orderAttr[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};

function sendOrder(submit, doorname, floor, phone, comment, payment){
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'checkout.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let params = "checkout=" + submit + "&doorname=" + doorname + "&floor=" + floor + "&phone=" + phone + "&comment=" + comment + "&payment=" + payment;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				location.href = "success.php";
			}
			else if(this.responseText == false || this.responseText == ""){
				document.getElementById('false').classList.add("my-2");
				document.getElementById('false').innerHTML = "<div class='alert alert-danger alert-dismissible fade show'>" +
                													"<button type='button' class='close' data-dismiss='alert'>&times;</button>Κάτι πήγε λάθος. Δοκίμασε ξανά." +
																  "</div>";
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
		}
	}
	xhr.send(params);
}