//Register
const emailR = document.getElementById('emailR');
const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const password = document.getElementById('password');
const input = [firstName, lastName];

//Email Register validate
emailR.addEventListener('input', function() {
	if(emailValidated(emailR.value)) {
		emailR.closest(".group").querySelector('.text-danger').style.display = 'none';
		emailR.classList.remove("wrong");
	}
	else{
		emailR.closest(".group").querySelector('.text-danger').style.display = 'block';
		emailR.classList.add("wrong");
	}
});

//Password Register validate
password.addEventListener('input', function() {
	$("#password").next().css({"display": "none"});
	password.classList.remove("wrong");
	if(password.value.length === 0) {
		$("#password").next().css({"display": "block"});
		password.classList.add("wrong");
	}
	else if (password.value.length <= 8 && password.value.length > 0) {
		password.classList.add('wrong');
		$("#password").next().css({"display": "block"});
		$("#password").next().html("Ο κωδικός πρέπει να είναι μεγαλύτερος από 8 χαρακτήρες");
	}
});

for(let i = 0; i < input.length; i++){
	input[i].addEventListener('input', function(){
		this.closest(".group").querySelector('.text-danger').style.display = 'none';
		this.classList.remove("wrong");
		if (this.value == '') {
			this.closest(".group").querySelector('.text-danger').style.display = 'block';
			$(this).addClass("wrong");
			$("#resReg").empty();
		}
	});
}

const signUp = () => {
	$("#resReg").empty();

	let inputRegister = [emailR, firstName, lastName, password];

	if(FormValidated(inputRegister) && emailValidated(emailR.value)){

		$("#resReg").addClass("lds-dual-ring");
		
		let xhr = new XMLHttpRequest();
		let params = "email=" + emailR.value + "&firstName=" + firstName.value + "&lastName=" + lastName.value + "&pass=" + password.value;
		xhr.open('POST', '/php/userHandler.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == 1){
					document.getElementById('resReg').innerHTML = "";
					window.location.href = "./php/success.php";
				}
				else if(this.responseText == 0){
					$("#resReg").removeClass("lds-dual-ring").html("<p class='text-center mt-3' style='color: #dc3545 !important'>Κάτι πήγε λάθος, δοκίμασε ξανά!</p>");
				}
				else{
					$("#resReg").removeClass('lds-dual-ring').html(`<p class='text-center mt-3' style='color: #dc3545 !important'>${  }</p>`);
				}
			}
		};
		xhr.send(params);
	}
}


let emailValidated = (email) => {
	//General Email Regex (RFC 5322 Official Standard)
	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
};

let FormValidated = (input) => {
	let val = true;
	for(let i = 0; i < input.length; i++){
		if(input[i].value == ""){
			input[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			input[i].classList.add('wrong');
			val = false;
		}
	}
	if (password.value.length < 8 && password.value) {
		password.classList.add('wrong');
		$("#password").next().css({"display": "block"});
		$("#password").next().html("Ο κωδικός πρέπει να είναι μεγαλύτερος από 8 χαρακτήρες");
		val = false;
	}
	return val;
};

//Clear warnings on browser tab change
let clearWarns = () => {
	for (let i = 0; i < warnTexts.length; i++) {
		document.addEventListener('visibilitychange', function(){
			document.getElementsByClassName('text-danger')[i].style.display = 'none';
		});
		document.getElementsByClassName('text-danger')[i].style.display = 'none';
	}
};