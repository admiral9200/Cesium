var doorname = document.getElementById('doorname');
var floor = document.getElementById('floor');
var loader = document.getElementById("loader");
var blurred = document.getElementById("blurred");

function isValidatedCheckout(){
	var val = true;
	var orderAttr = [doorname, floor];
	var payment = document.querySelectorAll('input[name="payment"]:checked');
	if (Object.keys(payment).length === 0){
		document.getElementById('payment').style.display = 'block';
		$("label[class='form-check-label'").addClass("wrong");
		val = false;
	}
	for(var i = 0; i < orderAttr.length; i++){
		if(orderAttr[i].value == ""){
			orderAttr[i].closest("div").querySelector('.text-danger').style.display = 'block';
			orderAttr[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
}

document.getElementById('checkout').addEventListener('click', function(){
	if (isValidatedCheckout()){
		var submit = this.value;
		var payment = document.querySelector('input[name="payment"]:checked');
		var phone = document.getElementById('phone').value;
		var comment = document.getElementById('comment').value;
		if (submit && doorname.value && floor.value && payment.value) {
			sendOrder(submit, doorname.value, floor.value, phone, comment, payment.value);
		}
	}
});

function sendOrder(submit, doorname, floor, phone, comment, payment){
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'checkout.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "checkout=" + submit + "&doorname=" + doorname + "&floor=" + floor + "&phone=" + phone + "&comment=" + comment + "&payment=" + payment;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				location.href = "success.php";
			}
			else if(this.responseText == false || this.responseText == ""){
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