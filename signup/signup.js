//Register Form
const email = document.getElementById('email');
const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const mobile = document.getElementById('mobile');
const password = document.getElementById('password');
const passwordRetype = document.getElementById('passwordRetype');
const termsAccept = document.getElementById('termsAccept');
//Register Form
let form = [email, password, passwordRetype, firstName, lastName, mobile, termsAccept];

//Clear warnings on browser tab change
for (let i = 0; i < form.length; i++) {
	document.addEventListener('visibilitychange', function(){
		$(form[i]).removeClass("wrong");
		$(".text-danger").hide();
	});
}

//Email Register validate
$("#email").on('input', function() {
	let email = $(this).val();

	if(!emailValidated(email) && email !== ""){
		$(this).addClass("wrong");
		$("#warnEmail").show().html("Πρέπει να συμπληρώσεις μία έγκυρη διεύθυνση email.");
	}
	else if (email === "") {
		$(this).addClass("wrong");
		$("#warnEmail").show().html("Πρέπει να συμπληρώσεις το email σου.");
	}
	else {
		$(this).removeClass("wrong");
		$("#warnEmail").hide();
	}
});

//Password Register validate
password.addEventListener('input', function() {
	$("#password").next().hide();
	$("#password").removeClass("wrong");

	if(password.value.length === 0) {
		$("#password").next().show();
		$("#password").addClass("wrong");
	}
	else if (password.value.length <= 8 && password.value.length > 0) {
		$("#password").addClass("wrong");
		$("#password").next().show().html("Ο κωδικός πρέπει να είναι μεγαλύτερος από 8 χαρακτήρες");
	}
});

passwordRetype.addEventListener('input', function() {
	$("#passwordRetype").next().hide();
	$("#passwordRetype").removeClass("wrong");

	if(passwordRetype.value.length === 0) {
		$("#password").next().show();
		$("#password").addClass("wrong");
	}
	if (passwordRetype.value !== password.value) {
		$("#passwordRetype").addClass("wrong");
		$("#passwordRetype").next().show().html("Ο κωδικός που έχεις εισάγει δεν είναι ίδιος με τον προηγούμενο.");
	}
});

for(let i = 3; i < form.length; i++){
	form[i].addEventListener('input', function(){
		this.closest(".group").querySelector('.text-danger').style.display = 'none';
		this.classList.remove("wrong");
		if (this.value === '') {
			this.closest(".group").querySelector('.text-danger').style.display = 'block';
			$(this).addClass("wrong");
			$("#response").empty();
		}
	});
}

const signUp = async () => {
	$("#response").empty();

	if(FormValidated(form) && emailValidated(email.value)){

		$("#loader, #blurred").show();
		$('body').addClass('stop-scrolling');
		
		try {
			let params = {
				email: email.value,
				password: password.value,
				passwordRetype: passwordRetype.value,
				firstName: firstName.value,
				lastName: lastName.value,
				mobile: mobile.value,
				termsAccept: termsAccept.value
			}

			let response = await fetch('/php/userHandler.php', {
				method: 'POST',
				body: JSON.stringify(params),
				headers: {
					"Content-type" : "application/json; charset=UTF-8"
				}
			});

			if (response.ok) {
				let resolve = await response.json();

				if (resolve.status === "success") {
					$("#registerForm").empty().html(`<div class="container">
														<div class="alert alert-success" role="alert">
															<div class="text-center">
																<img src="/images/success.png" class="chk" alt="Success">
															</div>
															<h1 class="text-center">Καλωσήρθες στο Chip Coffee!</h1>
															<p class="text-center">Η εγγραφή σου έγινε με επιτυχία. Θα λάβεις ένα email για την επιβεβαίωση του λογαριασμού σου.</p>
															<div class="row justify-content-center">
																<a role="button" class="btn mainbtn btn-lg" href="/">Πίσω στην αρχική</a>
															</div>
														</div>
													</div>`);
				}
				else if (resolve.status) {
					$("#response").html(resolve.status);
				}
			}
			else if (!response.ok) {
				$("#response").html(resolve.status);
			}
		}
		catch (error) {
			$("#response").html(error);
		}
		finally {
			$("#loader").hide();
			$("#blurred").hide();
			$('body').removeClass('stop-scrolling');
		}
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
	if (!termsAccept.checked){
		$("#termsAccept").addClass("wrong");
		$("#termsAccept").next().show();
		val = false;
	}
	if (password.value.length < 8 && password.value) {
		$("#password").addClass("wrong");
		$("#password").next().html("Ο κωδικός πρέπει να είναι μεγαλύτερος από 8 χαρακτήρες").show();
		val = false;
	}
	if (passwordRetype.value !== password.value) {
		$("#passwordRetype").addClass("wrong");
		$("#passwordRetype").next().show().html("Ο κωδικός που έχεις εισάγει δεν είναι ίδιος με τον προηγούμενο.");
		val = false;
	}
	return val;
};