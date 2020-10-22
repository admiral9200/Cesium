let loader = document.getElementById("loader");
let blurred = document.getElementById("blurred");
let orderAgainBtn = document.getElementsByClassName('orderAgain');

//fetch user profile name
let getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '../php/functions.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			prof = JSON.parse(this.responseText);
			document.getElementById('wlcm').innerHTML += prof[0].firstName;
			document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
		}
	};
	xhr.send();
};

//Check if there is address stored
let addressHandler = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', 'address.php?check', true);
	xhr.onload = function(){
		if (this.status == 200) {
			if (this.responseText == 0) {
				$("#home").load("address_menu.html", () => {
					let address = document.getElementById('address');
					let state = document.getElementById('state');

					document.getElementById('add').addEventListener('click', addAddress);

					address.addEventListener('keyup', function(e){
						address.closest(".group").querySelector('.text-danger').style.display = 'none';
						address.classList.remove("wrong");
						if(address.value == "") {
							address.closest(".group").querySelector('.text-danger').style.display = 'block';
							address.classList.add("wrong");
						}
						if (e.keyCode === 13 || e.key === 13) addAddress();
					});

					state.addEventListener('keyup', function(e){
						state.closest(".group").querySelector('.text-danger').style.display = 'none';
						state.classList.remove("wrong");
						if(state.value == "") {
							state.closest(".group").querySelector('.text-danger').style.display = 'block';
							state.classList.add("wrong");
						}
						if (e.keyCode === 13 || e.key === 13) addAddress();
					});
				});
			}
			else if (this.responseText >= 1){
				document.getElementById('home').innerHTML = "<button class='btn mainbtn btn-lg btn-block text-white' role='button' onclick='order()'>Παράγγειλε τώρα</button>";
			}
		}
	};
	xhr.send();
};

//fetch address in address menu
let fetchAddress = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', 'address.php?fetch', true);
	xhr.onload = function(){
		if (this.status == 200) {
			let addresses = JSON.parse(this.responseText);
			if (addresses.length > 0) {
				for (let i = 0; i < addresses.length; i++) {
					let li = "<li class='list-group-item m-0 border-0'>" +
									"<div class='row d-flex justify-content-start align-items-center'>" +
										"<div class='col-xl-3 col-6'>" +
											`<h6 class='m-0'>${addresses[0].address}</h6>` +
										"</div>" +
										"<div class='col-xl-3 col-6'>" +
											`<h6 class='m-0'>${addresses[0].state}</h6>` +
										"</div>" +
										"<div class='col-xl-2 col-12'>" +
											`<button id='delete' class='btn btn-block btn-danger mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3' role='button' onclick='deleteAddress("${addresses[0].address}")'>Διαγραφή</button>` +
										"</div>" +
									"</div>" +
								"</li>";
					document.getElementById('addresses').innerHTML = li;
					for (let k = 0; k <= orderAgainBtn.length; k++){
						orderAgainBtn[k].disabled = false;
						orderAgainBtn[k].removeAttribute("title");
						orderAgainBtn[k].classList.remove("disableOrderAgainBtn");
					}
				}	
			}
			else{
				let li = "<li class='list-group-item m-0 border-0'>" +
							"<h6>Δεν υπάρχει ενεργή διεύθυνση</h6>" +
						"</li>";
				document.getElementById('addresses').innerHTML = li;
				for (let k in orderAgainBtn){
					orderAgainBtn[k].title = "Πρέπει να προσθέσεις μία διεύθυνση πρώτα.";
					orderAgainBtn[k].disabled = true;
					orderAgainBtn[k].classList.add("disableOrderAgainBtn");
				}
			}
		}
	};
	xhr.send();
};

//Invoke functions at load
(() => {
	getProfile();
	addressHandler();
	fetchAddress();
})();

let order = () => location.href = "../order/";

function addAddress(){
	if(validateAddress()){
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'address.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		let params = "address=" + address.value + "&state=" + state.value;
		xhr.onload = function(){
			if(this.status == 200){
				if(this.responseText == true){
					addressHandler();
					fetchAddress();
					reset();
				}
				else{
					document.getElementById('false').innerHTML = this.responseText;
					addressHandler();
					fetchAddress();
					reset();
				}
			}
		};
		xhr.send(params);
	}
}

let deleteAddress = (address) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'address.php?address=' + address, true);
	xhr.onreadystatechange = function(){
		if(this.status == 200){
			addressHandler();
			fetchAddress();
			$("#msg").html(this.responseText);
			reset();
		}
		else{
			document.getElementById('false').innerHTML = this.responseText;
			addressHandler();
			fetchAddress();
			reset();
		}
	};
	xhr.send();
};

let validateAddress = () => {
	let form = [address, state];
	let val = true;
	for(let i = 0; i < form.length; i++){
		if(form[i].value == ""){
			form[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			form[i].classList.add('wrong');
			val = false;
		}
		else if(/[^α-ωίϊΐόάέύϋΰήώΑ-Ωa-zA-Z0-9\-\s]/.test(form[i].value)) { //validate special chars
			form[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			form[i].closest(".group").querySelector('.text-danger').innerHTML = "Δεν είναι έγκυρο αυτό που συμπλήρωσες";
			form[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};

let reset = () => {
	loader.style.display = "none";
	blurred.style.display = "none";
	$('body').removeClass('stop-scrolling');
};