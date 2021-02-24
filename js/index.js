const rememberme = document.querySelector('#rememberme');
//Warn Texts
const warnTexts = document.getElementsByClassName('text-danger');
//Newsletter
const emailNewsletter = document.getElementById('emailNewsletter');
const subscribeBtn = document.getElementById('subscribe');

//Clear warnings on browser tab change
for (let i = 0; i < warnTexts.length; i++) {
	document.addEventListener('visibilitychange', function(){
		document.getElementsByClassName('text-danger')[i].style.display = 'none';
	});
}

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

$("#password").on('input', function() {
	$(this).removeClass("wrong");
	$("#warnPassword").hide();

	if ($(this).val() === "") {
		$(this).addClass("wrong")
		$("#warnPassword").show();
	}
});

const goToSignUp = () => location.href = '/signup/';

$("#signIn").click(function (e) { 
	e.preventDefault();
	signIn();
});

const signIn = async () => {
	let email = $('#email');
	let pass = $("#password");
	let inputs = [email, pass];

	if(FormValidated(inputs) && emailValidated(email.value)){
		$("#res").empty().addClass("lds-dual-ring");

		try {
			let params = {
				email,
				pass,
				rememberme: rememberme.checked
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
					$("#res").empty();
					window.location.href = "./home/";
				}
				else if (resolve.status) {
					$("#res").removeClass('lds-dual-ring').html(`<p class='text-center' style='color: #dc3545 !important'>${ resolve.status }</p>`);
				}
			}
		}
		catch (error) {
			$("#res").removeClass('lds-dual-ring').html(`<p class='text-center' style='color: #dc3545 !important'>${ error }</p>`);
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
		if(input[i].value === ""){
			input[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			input[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};