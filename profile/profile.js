const loader = document.getElementById("loader");
const blurred = document.getElementById("blurred");
//forms
const inputs = document.getElementsByTagName("input");
const resPass = document.getElementById('resPass');
const oldpass = document.getElementById("oldpass");
const newpass = document.getElementById("newpass");

let email = $("#email").val();

const getProfile = async () => {
	try {
		let response = await fetch('profile.php?user=' + email);

		if (response.ok) {
			let res = await response.json();

			if (!res.error){
				$("#dropdownMenuLink").html(`${ res[0].firstName } <i class='far fa-user'></i>`);
				$("#fullName").html(`${ res[0].firstName } ${ res[0].lastName }`);
				$("#firstName").val(res[0].firstName);
				$("#lastName").val(res[0].lastName);
			}
			else if (res.error === 'Internal Error') {
				$("#dropdownMenuLink").html(`<i class='far fa-user'></i>`);
			}
		}
	} 
	catch (error) {
		
	}
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

const changeCreds = async () => {

	const firstName = document.getElementById("firstName");
	const lastName = document.getElementById("lastName");

	if(validateForm(firstName, lastName)){

		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');

		try {
			let params = {
				firstName: firstName.value,
				lastName: lastName.value
			};

			let response = await fetch('profile.php', {
				method: "POST",
				body: JSON.stringify(params),
				headers: {
					"Content-type": "application/json; charset=UTF-8"
				}
			});

			if (response.ok) {
				let res = await response.json();

				if (res.status === 'success') {
					$("#info").html(`<div class='alert alert-success alert-dismissible fade show'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>Τα στοιχεία σου άλλαξαν επιτυχώς.
				   					</div>`);
					getProfile();
				}
				else if (res.error){
					$("#info").html(`<div class='alert alert-danger alert-dismissible fade show'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.error }
									</div>`);
				}
			}
			else if (!response.ok) {
				$("#info").html(`<div class='alert alert-danger alert-dismissible fade show'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.status }
								</div>`);
			}
		} 
		catch (error) {
			$("#info").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
							</div>`);
		}
		finally {
			removeLoader();
		}
	}
};

const changePass = async () => {
	if(validateForm(oldpass, newpass)){

		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');

		try {
			let params = {
				oldPassword: oldpass.value,
				newPassword: newpass.value
			};

			let response = await fetch('profile.php', {
				method: "POST",
				body: JSON.stringify(params),
				headers: {
					"Content-type": "application/json; charset=UTF-8"
				}
			});

			if (response.ok) {
				let res = await response.json();

				if (res.status === 'success') {
					$("#infoPass").html(`<div class='alert alert-success alert-dismissible fade show'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>Ο κωδικός σου άλλαξε επιτυχώς.
				   					</div>`);
					getProfile();
				}
				else if (res.error){
					$("#infoPass").html(`<div class='alert alert-danger alert-dismissible fade show'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.error }
									</div>`);
				}
			}
			else if (!response.ok) {
				$("#infoPass").html(`<div class='alert alert-danger alert-dismissible fade show'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.status }
								</div>`);
			}
		} 
		catch (error) {
			$("#infoPass").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
							</div>`);
		}
		finally {
			removeLoader();
		}
	}
};

const deleteAccount = async () => {
	try {
		let params = {
			email
		};

		let response = await fetch('profile.php', {
			method: "POST",
			body: JSON.stringify(params),
			headers: {
				"Content-type": "application/json; charset=UTF-8"
			}
		});

		if (response.ok) {
			let res = await response.json();

			if (res.error){
				$("#error").html(`<div class='alert alert-danger alert-dismissible fade show'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.error }
								</div>`);
			}
		}
		else if (!response.ok) {
			$("#error").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.status }
							</div>`);
		}
	} 
	catch (error) {
		$("#error").html(`<div class='alert alert-danger alert-dismissible fade show'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
						</div>`);
	}
};

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