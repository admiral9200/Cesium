var loader = document.getElementById("loader");
var blurred = document.getElementById("blurred");
var inputs = document.getElementsByTagName("input");

document.getElementById('changeCreds').addEventListener('click', changeCreds);
document.getElementById('changepass').addEventListener('click', changePass);

for (let i = 0; i < inputs.length; i++) {
	inputs[i].addEventListener('keyup', function(){
		$(inputs[i]).next().css({"display": "none"});
		inputs[i].classList.remove("wrong");
		if(inputs[i].value == "") {
			$(inputs[i]).next().css({"display": "block"});
			inputs[i].classList.add("wrong");
		}
	});	
}

function changeCreds(){
	var firstName = document.getElementById("firstName");
	var lastName = document.getElementById("lastName");
	if(validateForm(firstName, lastName)){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'profile.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "firstName=" + firstName.value + "&lastName=" + lastName.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					$("#viewProfile").load("view_profile.php", () => {
						loader.style.display = "none";
						blurred.style.display = "none";
						$('body').removeClass('stop-scrolling');
					});
				}
				else{
					$("#addresses").load("view_profile.php", () => {
						loader.style.display = "none";
						blurred.style.display = "none";
						$('body').removeClass('stop-scrolling');
					});
				}
			}
		}
		xhr.send(params);
	}
}

function changePass(){
	var oldpass = document.getElementById("oldpass");
	var newpass = document.getElementById("newpass");
	if(validateForm(oldpass, newpass)){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'profile.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var params = "oldpass=" + oldpass.value + "&newpass=" + newpass.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					$("#viewProfile").load("view_profile.php", () => {
						loader.style.display = "none";
						blurred.style.display = "none";
						$('body').removeClass('stop-scrolling');
					});
				}
				else{
					$("#viewProfile").load("view_profile.php", () => {
						loader.style.display = "none";
						blurred.style.display = "none";
						$('body').removeClass('stop-scrolling');
					});
				}
			}
		}
		xhr.send(params);
	}
}

function validateForm(value1, value2){
	var form = [value1, value2];
	var val = true;
	for(var i = 0; i < form.length; i++){
		if(form[i].value == ""){
			$(form[i]).next().css({"display": "block"});
			form[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
}