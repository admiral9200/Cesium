document.getElementById('login').addEventListener('click', loginUser);
document.getElementById('signup').addEventListener('click', registerUser);

function loginUser(e){
	var email = document.getElementById('email').value;
	var pass = document.getElementById('pass').value;
	var params = "email=" + email + "&pass=" + pass;
	if(validateEmail(email) && firstName !== "" && lastName !== "" && pass !== ""){
		e.preventDefault();
		var xhr = new XMLHttpRequest();
		xhr.open('POST', './php/login.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function(){
			if(this.status == 200){
				document.getElementById('res').innerHTML = this.responseText;
				if(this.responseText == "success") window.location.href = "home.php";
			}
		}
		xhr.send(params);
	}
}

function registerUser(e) {
	var email = document.getElementById('emailR').value;
	var firstName = document.getElementById('firstName').value;
	var lastName = document.getElementById('lastName').value;
	var pass = document.getElementById('password').value;
	if(validateEmail(email) && firstName !== "" && lastName !== "" && pass !== ""){
		e.preventDefault();
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
	const re = /\S+@\S+\//;
	return re.test(email);
}

(function() {
	'use strict';
	window.addEventListener('load', function() {
		var forms = document.getElementsByClassName('needs-validation');
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
		});
	}, false);
})();