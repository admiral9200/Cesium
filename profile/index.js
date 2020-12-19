const loader = document.getElementById("loader");
const blurred = document.getElementById("blurred");
//forms
const inputs = document.getElementsByTagName("input");
const resPass = document.getElementById('resPass');
const oldpass = document.getElementById("oldpass");
const newpass = document.getElementById("newpass");

const getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '/php/functions.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			let prof = JSON.parse(this.responseText);
			document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
			try {
				document.getElementById('email').value = prof[0].email;
				document.getElementById('firstName').value = prof[0].firstName;
				document.getElementById('lastName').value = prof[0].lastName;
				document.getElementById('fullName').innerHTML = `${prof[0].firstName} ${prof[0].lastName}`;
				document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
			} 
			catch (error) {
				
			}
		}
	};
	xhr.send();
};

(() => getProfile())();

//check for empty forms
for (let i = 0; i < inputs.length; i++) {
	inputs[i].addEventListener('keyup', () => {
		$(inputs[i]).next().css({"display": "none"});
		inputs[i].classList.remove("wrong");
		if(inputs[i].value == "") {
			$(inputs[i]).next().css({"display": "block"});
			inputs[i].classList.add("wrong");
		}
	}); 
}

for (let j = 0; j < 2; j++) {
	inputs[j].addEventListener('keyup', (e) => {
		if (e.keyCode === 13 || e.key === 13){
			changeCreds();
		}
	});
}

for (let j = 0; j > 2; j++) {
	inputs[j].addEventListener('keyup', (e) => {
		if (e.keyCode === 13 || e.key === 13){
			changePass();
		}
	});
}

document.getElementById('changeCreds').addEventListener('click', changeCreds);
document.getElementById('changepass').addEventListener('click', changePass);
document.getElementById('account_delete').addEventListener('click', deleteAccount);

function changeCreds(){
	const res = document.getElementById('res');
	const firstName = document.getElementById("firstName");
	const lastName = document.getElementById("lastName");
	if(validateForm(firstName, lastName)){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'profile.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		let params = "firstName=" + firstName.value + "&lastName=" + lastName.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					res.innerHTML = "<div class='alert alert-success alert-dismissible fade show'>" +
                    					"<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
                    						'Τα στοιχεία σου άλλαξαν επιτυχώς' +
               						"</div>";
					getProfile();
					removeLoader();
				}
				else{
					res.style.display = "block";
					res.classList.remove('alert-success');
					res.classList.add('alert-danger');
					res.innerHTML = this.responseText;
					getProfile();
					removeLoader();
				}
			}
		};
		xhr.send(params);
	}
}

function changePass(){
	if(validateForm(oldpass, newpass)){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'profile.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		let params = "oldpass=" + oldpass.value + "&newpass=" + newpass.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					resPass.innerHTML = "<div class='alert alert-success alert-dismissible'>" +
                    						"<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
											"Ο κωδικός σας άλλαξε επιτυχώς" +
                						"</div>";
					removeLoader();
				}
				else{
					resPass.innerHTML = "<div class='alert alert-danger alert-dismissible'>" +
                    						"<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
											this.responseText +
                						"</div>";
					removeLoader();
				}
			}
		};
		xhr.send(params);
	}
}

function deleteAccount(){
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../php/functions.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let params = "delete=" + true;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				location.href = "../";
			}
			else if(this.responseText == false){
				//response on error
			}
		}
	};
	xhr.send(params);
}

const validateForm = (value1, value2) => {
	let form = [value1, value2];
	let val = true;
	for(let i = 0; i < form.length; i++){
		if(form[i].value == ""){
			$(form[i]).next().css({"display": "block"});
			form[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};

const removeLoader = () => {
	loader.style.display = "none";
	blurred.style.display = "none";
	$('body').removeClass('stop-scrolling');
};