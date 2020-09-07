document.getElementById('login').addEventListener('click', loginUser);
document.getElementById('signup').addEventListener('click', registerUser);

var email = document.getElementById('email');
var emailWarn = document.getElementById('eWarn');
var pass = document.getElementById('pass');
var passWarn = document.getElementById('pWarn');

emailFeedback.addEventListener('keyup', function(){
	if(validateEmail(email.value)){
		emailWarn.style.display = 'none';
		email.classList.remove("wrong");
	}
	else{
		emailWarn.style.display = 'block';
		email.classList.add("wrong");
	}
});	

passFeedback.addEventListener('keypress', function() {
	passWarn.style.display = 'none';
	pass.classList.remove("wrong");
	if(pass.value == "") {
		passWarn.style.display = 'block';
		pass.classList.add("wrong");
	}
});

function loginUser(e){
	e.preventDefault();
	var params = "email=" + email.value + "&pass=" + pass.value;
	if(email.value == ""){
		emailWarn.style.display = 'block';
		email.classList.add("wrong");
		if(pass.value == ""){
			passWarn.style.display = 'block';
			pass.classList.add("wrong");
		}
	}
	else if(pass.value == ""){
		passWarn.style.display = 'block';
		pass.classList.add("wrong");
	}
	else{
		document.getElementById('res').innerHTML = "";
		document.getElementById('res').classList.add('lds-dual-ring');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', './php/login.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function(){
			if(this.status == 200){
				document.getElementById('res').classList.remove('lds-dual-ring');
				document.getElementById('res').innerHTML = this.responseText;
				if(this.responseText == true) window.location.href = "home.php";
			}
		}
		xhr.send(params);
	}
}

function registerUser(e){
	e.preventDefault();
	var email = document.getElementById('emailR').value;
	var firstName = document.getElementById('firstName').value;
	var lastName = document.getElementById('lastName').value;
	var pass = document.getElementById('password').value;
	if(validateEmail(email) && firstName !== "" && lastName !== "" && pass !== ""){
		var params = "email=" + email + "&firstName=" + firstName + "&lastName=" + lastName + "&pass=" + pass;
		var xhr = new XMLHttpRequest();
		xhr.open('POST', './php/register.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function(){
			if(this.status == 200){
				document.getElementById('resReg').innerHTML = this.responseText;
				if(this.responseText == "success") window.location.href = "success_register.php";
			}
		}
		xhr.send(params);
	}
}

function validateEmail(email) {
	const re = /^.+@.+\..+$/;
	return re.test(email);
}