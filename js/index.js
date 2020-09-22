document.getElementById('login').addEventListener('click', loginUser);
document.getElementById('signup').addEventListener('click', registerUser);

//Login
var email = document.getElementById('email');
var pass = document.getElementById('pass');
var checkrm = document.getElementById('check').value;
//Login warns
var emailWarn = document.getElementById('eWarn');
var passWarn = document.getElementById('pWarn');
//Register
var inputRegister = document.getElementById('signupForm').querySelectorAll('input');
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
		emailWarn.style.display = 'none';
		email.classList.remove("wrong");
	}
	else{
		emailWarn.style.display = 'block';
		email.classList.add("wrong");
		emailWarn.innerHTML = "Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.";
	}
});	

pass.addEventListener('keyup', function() {
	passWarn.style.display = 'none';
	pass.classList.remove("wrong");
	if(pass.value == "") {
		passWarn.style.display = 'block';
		pass.classList.add("wrong");
	}
});

function loginUser(e){
	e.preventDefault();
	if(email.value == ""){
		emailWarn.style.display = 'block';
		email.classList.add("wrong");
		emailWarn.innerHTML = "Πρέπει να συμπληρώσεις το email σου.";
		if(pass.value == ""){
			passWarn.style.display = 'block';
			pass.classList.add("wrong");
		}
		document.getElementById('res').innerHTML = "";
	}
	else if(pass.value == ""){
		passWarn.style.display = 'block';
		pass.classList.add("wrong");
		document.getElementById('res').innerHTML = "";
	}
	else{
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

for(var i = 1; i < inputRegister.length; i++){
	inputRegister[i].addEventListener('keyup', function(){
		this.closest(".group").querySelector('.text-danger').style.display = 'none';
		this.classList.remove("wrong");
		if (this.value == '') {
			this.closest(".group").querySelector('.text-danger').style.display = 'block';
			this.classList.add("wrong");
			document.getElementById('resReg').innerHTML = "";
		}
	});
}

function registerUser(e){
	e.preventDefault();
	document.getElementById('resReg').innerHTML = "";
	if(validateRegister()){
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
	const re = /^.+@.+\..+$/;
	//General Email Regex (RFC 5322 Official Standard)
	//const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function validateRegister() {
	var val = true;
	for(var i = 0; i < inputRegister.length; i++){
		if(inputRegister[i].value == ""){
			inputRegister[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			inputRegister[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
}