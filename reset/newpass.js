var newPass = document.getElementById('newpass');
var confirmNewPass = document.getElementById('confirmNewPass');
var res = document.getElementById('res');

newPass.addEventListener('keyup', (e) => {
	$(newPass).next().css({"display": "none"});
	newPass.classList.remove("wrong");
	if(newPass.value.length === 0) {
		$(newPass).next().css({"display": "block"});
		$(newPass).next().html("Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.");
		newPass.classList.add("wrong");
	}
	else if (newPass.value.length <= 8 && newPass.value.length > 0) {
		newPass.classList.add('wrong');
		$(newPass).next().css({"display": "block"});
		$(newPass).next().html("Ο κωδικός πρέπει να είναι μεγαλύτερος από 8 χαρακτήρες");
	}
	if (e.keyCode === 13 || e.key === 13) submitNewPass();
});

confirmNewPass.addEventListener('keyup', (e) => {
	$(confirmNewPass).next().css({"display": "none"});
	confirmNewPass.classList.remove("wrong");
	if(confirmNewPass.value.length === 0) {
		$(confirmNewPass).next().css({"display": "block"});
		$(confirmNewPass).next().html("Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.");
		confirmNewPass.classList.add("wrong");
	}
	else if (confirmNewPass.value !== newPass.value) {
		confirmNewPass.classList.add('wrong');
		$(confirmNewPass).next().css({"display": "block"});
		$(confirmNewPass).next().html("Ο κωδικός δεν είναι ίδιος με τον προηγούμενο.");
	}
	if (e.keyCode === 13 || e.key === 13) submitNewPass();
});

document.getElementById('submitNewPass').addEventListener('click', submitNewPass);

function submitNewPass(){
	if(validatePasswords(newPass, confirmNewPass)){
		res.innerHTML = "";
		res.classList.add('lds-dual-ring');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'reset.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "submit=" + true + "&newPass=" + newPass.value + "&confirm=" + confirmNewPass.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					res.classList.remove('lds-dual-ring');
					$("#resetform").fadeOut(100, () => {
						$("#resetform").load("success.php", () => {
							$("#resetform").fadeIn(100);
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

function validatePasswords(pass, pass2){
	var val = true;
	var arr = [pass, pass2];
	for (let i = 0; i < arr.length; i++) {
		if(arr[i].value === ""){
			$(arr[i]).next().css({"display": "block"});
			$(arr[i]).next().html("Πρέπει να συμπληρώσεις ένα κωδικό πρόσβασης.");
			arr[i].classList.add("wrong");
			val = false;
		}
	}
	return val;
}