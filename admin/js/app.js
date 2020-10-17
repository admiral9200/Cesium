/*jshint esversion: 6 */
particlesJS.load('particles-js', 'particles.json');

document.getElementById('login').addEventListener('click', loginUser);

function loginUser(e){
    e.preventDefault();
    var email = document.getElementById('email');
    var pass = document.getElementById('pass');
    var input = [email, pass];
    if(isFormEmpty(input) && validateEmail(email.value)){
        document.getElementById('res').innerHTML = "";
        document.getElementById('res').classList.add('lds-dual-ring');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './php/login.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var params = "email=" + email.value + "&pass=" + pass.value;
        xhr.onload = function(){
            if(this.status == 200){
                if(this.responseText == true){
                    document.getElementById('res').innerHTML = "";
                    window.location.href = "dashboard.php";
                }
                else{
                    document.getElementById('res').classList.remove('lds-dual-ring');
                    document.getElementById('res').innerHTML = "<p style='color: red !important'>" + this.responseText + "</p>";
                }
            }
        }
        xhr.send(params);
    }
}

let validateEmail = (email) => {
	//General Email Regex (RFC 5322 Official Standard)
	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
};

let isFormEmpty = (input) => {
	let val = true;
	for(let i = 0; i < input.length; i++){
		if(!input[i].value){
			input[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};