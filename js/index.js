document.getElementById('login').addEventListener('click', loginUser);
document.getElementById('signup').addEventListener('click', registerUser);

//Login
var email = document.getElementById('email');
var pass = document.getElementById('pass');
var checkrm = document.getElementById('check').value;
//Register
var emailR = document.getElementById('emailR');
var firstName = document.getElementById('firstName');
var lastName = document.getElementById('lastName');
var password = document.getElementById('password');


//Clear warnings on browser tab change
let warnTexts = document.getElementsByClassName('text-danger');
for (let i = 0; i < warnTexts.length; i++) {
	document.addEventListener('visibilitychange', function(){
		document.getElementsByClassName('text-danger')[i].style.display = 'none';
	});	
}

email.addEventListener('keyup', function(){
	if(validateEmail(email.value)){
		$("#email").next().css({"display": "none"});
		email.classList.remove("wrong");
	}
	else{
		$("#email").next().css({"display": "block"});
		$("#email").next().html("Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.");
		email.classList.add("wrong");
	}
});	

pass.addEventListener('keyup', function() {
	$("#pass").next().css({"display": "none"});
	pass.classList.remove("wrong");
	if(pass.value == "") {
		$("#pass").next().css({"display": "block"});
		pass.classList.add("wrong");
	}
});

//Email Register validate
emailR.addEventListener('keyup', function() {
	if(validateEmail(emailR.value)) {
		emailR.closest(".group").querySelector('.text-danger').style.display = 'none';
		emailR.classList.remove("wrong");
	}
	else{
		emailR.closest(".group").querySelector('.text-danger').style.display = 'block';
		emailR.classList.add("wrong");
	}
});

//Password Register validate
password.addEventListener('keyup', function() {
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

var input = [firstName, lastName];
for(var i = 0; i < input.length; i++){
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

function loginUser(e){
	e.preventDefault();
	var inputLogin = [email, pass];
	if(isFormEmpty(inputLogin) && validateEmail(email.value)){
		document.getElementById('res').innerHTML = "";
		document.getElementById('res').classList.add('lds-dual-ring');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', './php/login.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "email=" + email.value + "&pass=" + pass.value + "&checkrm=" + checkrm;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					document.getElementById('res').innerHTML = "";
					window.location.href = "./home/";
				}
				else{
					document.getElementById('res').classList.remove('lds-dual-ring');
					document.getElementById('res').innerHTML = this.responseText;
				}
			}
		}
		xhr.send(params);
	}
}

function registerUser(e){
	e.preventDefault();
	document.getElementById('resReg').innerHTML = "";
	var inputRegister = [emailR, firstName, lastName, password];
	if(isFormEmpty(inputRegister) && validateEmail(emailR.value)){
		document.getElementById('resReg').classList.add('lds-dual-ring');
		var xhr = new XMLHttpRequest();
		var params = "email=" + emailR.value + "&firstName=" + firstName.value + "&lastName=" + lastName.value + "&pass=" + password.value;
		xhr.open('POST', './php/register.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					document.getElementById('resReg').innerHTML = "";
					window.location.href = "success_register.php";
				}
				else if(this.responseText == false){
					document.getElementById('resReg').classList.remove('lds-dual-ring');
					document.getElementById('resReg').innerHTML = "<p class='text-center mt-3' style='color: #dc3545 !important'>Κάτι πήγε λάθος, δοκίμασε ξανά!</p>";
				}
				else{
					document.getElementById('resReg').classList.remove('lds-dual-ring');
					document.getElementById('resReg').innerHTML = this.responseText;
				}
			}
		}
		xhr.send(params);
	}
}

function validateEmail(email) {
	//General Email Regex (RFC 5322 Official Standard)
	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function isFormEmpty(input) {
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
}