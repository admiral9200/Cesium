var email = document.getElementById('email');
var res = document.getElementById('res');

document.getElementById('reset').addEventListener('click', resetPass);

email.addEventListener('keyup', (e) => {
	if(validateEmail(email.value)){
		$("#email").next().css({"display": "none"});
		email.classList.remove("wrong");
	}
	else{
		$("#email").next().css({"display": "block"});
		$("#email").next().html("Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.");
		email.classList.add("wrong");
	}
	if (e.keyCode === 13 || e.key === 13) resetPass();
});

function validateEmail(email) {
	//General Email Regex (RFC 5322 Official Standard)
	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function resetPass(){
	if(isEmpty(email) && validateEmail(email.value)){
		res.innerHTML = "";
		res.classList.add('lds-dual-ring');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'reset.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "email=" + email.value + "&reset=" + true;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					res.classList.remove('lds-dual-ring');
					$("#resetform").fadeOut(400, () => {
						$("#resetform").load("newpass.php", () => {
							$("#resetform").fadeIn(400);
						});
					});
				}
				else if(this.responseText == false){
					res.classList.remove('lds-dual-ring');
					res.classList.add("text-danger");
					res.innerHTML = "Κάτι πήγε λάθος. Δοκίμασε ξανά σε λίγο";
				}
				else{
					res.classList.remove('lds-dual-ring');
					res.classList.add("text-danger");
					res.innerHTML = this.responseText;
				}
			}
		}
		xhr.send(params);
	}
}

function isEmpty(email){
	if(email.value){
		$(email).next().css({"display": "none"});
		email.classList.remove("wrong");
		return true;
	}
	else{
		$(email).next().css({"display": "block"});
		$(email).next().html("Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.");
		email.classList.add("wrong");
		return false;
	}
}