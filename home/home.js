const loader = document.getElementById("loader");
const blurred = document.getElementById("blurred");
const orderAgainBtn = document.getElementsByClassName('orderAgain');
const address = document.getElementById('address');
const state = document.getElementById('state');
const input = [address, state];
let addresses, orders;

const ValidateEmptyForms = () => {
	for (let i = 0; i < input.length; i++) {
		input[i].addEventListener('keyup', function(e){
			input[i].closest(".group").querySelector('.text-danger').style.display = 'none';
			input[i].classList.remove("wrong");
			if(input[i].value == "") {
				input[i].closest(".group").querySelector('.text-danger').style.display = 'block';
				input[i].classList.add("wrong");
			}
			if (e.keyCode === 13 || e.key === 13) {
				addAddress(address.value, state.value);
			}
		});
	}
};

//Check if there is address stored in db
const addressHandler = async () => {
	$("#address").val('');
	$("#state").val('');

	try {
		let response = await fetch('addressHandler.php?q');

		if (response.ok) {
			let resolver = await response.json();

			$('#home').fadeOut(300, () => {
				$('#home').removeClass('lds-dual-ring-sm d-flex justify-content-center');

				if (resolver === 0) {
					$("#home").html(`<h2>Έχεις όρεξη για καφέ; Πρόσθεσε τη διεύθυνση σου και παράγγειλε!</h2>
									<button class='btn mainbtn btn-lg btn-block text-white disableBtn' disabled>Παράγγειλε τώρα</button>`);
				}
				else if (resolver > 0){
					$("#home").html("<button class='btn mainbtn btn-lg btn-block text-white' role='button' onclick='order()'>Παράγγειλε τώρα</button>");
				}
				$('#home').fadeIn(300);
			});
		}
	} 
	catch (error) {
		$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
							</div>`);
	}
};

//fetch address in address menu
const fetchAddress = async () => {
	let address_list = '';

	try {
		let response = await fetch('addressHandler.php?f');

		if (response.ok) {
			let addresses = await response.json();

			if(addresses.length > 0){
				for (let i = 0; i < addresses.length; i++) {
					address_list += `<li class='list-group-item m-0 border-0'>
										<div class='row d-flex justify-content-start align-items-center'>
											<div class='col-xl-3 col-6'>
												<h6 class='m-0'>${ addresses[i].address }</h6>
											</div>
											<div class='col-xl-3 col-6'>
												<h6 class='m-0'>${ addresses[i].state }</h6>
											</div>
											<div class='col-xl-2 col-12'>
												<button id='delete' class='btn btn-block btn-danger mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3' role='button' onclick='deleteAddress("${ addresses[i].address }")'>Διαγραφή</button>
											</div>
										</div>
									</li>`;
					for (let k = 0; k <= orderAgainBtn.length; k++){
						try {
							orderAgainBtn[k].disabled = false;
							orderAgainBtn[k].removeAttribute("title");
							orderAgainBtn[k].classList.remove("disableBtn");	
						}
						catch (error) {}
					}
				}
			}
			else if (addresses.length === 0){
				address_list = `<li class='list-group-item m-0 border-0'>
										<h6>Δεν υπάρχει ενεργή διεύθυνση</h6>
									</li>`;
				for (let k in orderAgainBtn){
					try {
						orderAgainBtn[k].title = "Πρέπει να προσθέσεις μία διεύθυνση πρώτα.";
						orderAgainBtn[k].disabled = true;
						orderAgainBtn[k].classList.add("disableBtn");	
					}
					catch (error) {}
				}
			}
			else if (addresses.error){
				$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ addresses.error }
							</div>`);
			}
			$('#addresses').fadeOut(300, function(){
				$(this).removeClass('lds-dual-ring-sm-bl d-flex justify-content-center').html(address_list).fadeIn(300);
			});
		}	
	} 
	catch (error) {
		$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
							</div>`);
	}
};

const fetchOrders = async () => {
	try {
		let response = await fetch('addressHandler.php?orders');
		if(response.ok){
			orders = await response.json();

			if(orders.length > 0){
				for (let i = 0; i < orders.length; i++) {

					let date = orders[i].date.slice(0, 2) + '/' + orders[i].date.slice(3, 5) + '/' + orders[i].date.slice(6, 10);
					let coffees = orders[i].coffees.split(',');
					let qtys = orders[i].qty.split(',');
					let totalPrice = orders[i].price.split(',').reduce((acc, cur) => parseFloat(acc) + parseFloat(cur));

					$("#orders").append(`<li class='list-group-item mt-2 mb-4'>
											<div class='row'>
												<div class='col-xl-3 col-lg-3 col-md-3 col-6 text-xl-left text-lg-left text-left my-auto'>
													<h6>${orders[i].id}</h6>
												</div>
												<div class='col-xl-3 col-lg-3 col-md-3 col-6 text-xl-left text-lg-left text-right my-auto'>
													<h6>${date}</h6>
													<p>${orders[i].time}</p>
												</div>
												<div class='col-xl-3 col-lg-3 col-md-3 col-12 my-auto'>
													${(() => {
														let string = '';
														for (let k = 0; k < coffees.length; k++){
															string +=	`<div class='row m-xl-0 m-lg-0 m-md-0 mx-1'>
																			<h6 class='mr-2'>${qtys[k]}x</h6><h6>${coffees[k]}</h6>
																		</div>`;
														}
														return string;
													})()}
												</div>
												<div class='col-xl-1 col-lg-1 col-md-1 col-12 cost my-auto'>
													<h6>
														${ totalPrice.toFixed(2) }€
													</h6>
												</div>
												<div class="col-xl-2 col-lg-2 col-md-2 col-12 my-auto">
													<button type="button" class="btn mainbtn btn-block text-white orderAgain" onclick="orderAgain(${orders[i].id})">Παράγγειλε ξανά</button>
												</div>
											</div>
										</li>`);	
				}
			}
			else if (orders.length === 0){
				$("#orders").append(`<li class='list-group-item mt-2 mb-4'>
										<h6>Δεν υπάρχει καμία παραγγελία.</h6>
									</li>`);
			}
			else if (orders.error === 'Internal Error'){
				$("#orders").append(`<li class='list-group-item mt-2 mb-4'>
										<h6>Unexpected Error..</h6>
									</li>`);
			}
		}	
	} 
	catch (error) {
		
	}
};

//Invoke functions at load
(() => {
	addressHandler();
	fetchAddress();
	fetchOrders();
})();

//go to order page
const order = () => location.href = "/order/";

//add address to db
const addAddress = async (address, state) => {
	if(isAddressValidated(input) && noDuplicateAddress()){
		
		loader.style.display = "block";
		blurred.style.display = "block";
		$('body').addClass('stop-scrolling');

		let params = {
			address,
			state
		};
	
		try {
			let response = await fetch('addressHandler.php', {
				method: "POST",
				body: JSON.stringify(params),
				headers: {
					"Content-type": "application/json; charset=UTF-8"
				}
			});
	
			if (response.ok) {
				let res = await response.json();

				if (res.status && res.status === 'success'){
					addressHandler();
					fetchAddress();
				}
				else if (res.error){
					if (res.error === 'Internal Error'){
						$("#msg").html(`<div class='alert alert-danger alert-dismissible fade show'>
											<button type='button' class='close' data-dismiss='alert'>&times;</button>Δεν προσθέθηκε η διεύθυνση. Προσπάθησε ξανά.
										</div>`);
					}
					else if (res.error === 'Not Valid') {
						$("#msg").html(`<div class='alert alert-danger alert-dismissible fade show'>
											<button type='button' class='close' data-dismiss='alert'>&times;</button>Δεν είναι έγκυρο αυτό που συμπλήρωσες.
										</div>`);
					}
					else if (res.error === 'Over Limit') {
						$("#msg").html(`<div class='alert alert-danger alert-dismissible fade show'>
											<button type='button' class='close' data-dismiss='alert'>&times;</button>Δε μπορείτε να προσθέσετε άλλη διεύθυνση.
										</div>`);
					}
				}
			}
		} 
		catch (error) {
			$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
							</div>`);
		}
		finally {
			reset();
		}
	}
};

//remove address from db
const deleteAddress = async (address) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');

	let param = {
		address
	};

	try {
		let response = await fetch('addressHandler.php', {
			method: "POST",
			body: JSON.stringify(param),
			headers: {
				"Content-type": "application/json; charset=UTF-8"
			}
		});

		if (response.ok) {
			let res = await response.json();

			if (res.status === 'success'){
				$("#msg").html(`<div class='alert alert-success alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>Η διεύθυνση διαγράφηκε.
							</div>`);
			}
			else if (res.error === 'Internal Error'){
				$("#msg").html(`<div class='alert alert-danger alert-dismissible fade show'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>Προέκυψε σφάλμα στην διαγραφή.
								</div>`);
			}
		}
	} 
	catch (error) {
		$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
						</div>`);
	}
	finally {
		addressHandler();
		fetchAddress();
		reset();
	}
};

const orderAgain = async (code) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	
	let param = {
		code
	};

	try {
		let response = await fetch('/order/order.php', {
			method: "POST",
			body: JSON.stringify(param),
			headers: {
				"Content-type": "application/json; charset=UTF-8"
			}
		});
		
		if (response.ok) {
			let res = await response.json();
	
			if (res.length > 0 && res !== 'fail') {
				localStorage.clear();
				for (let i = 0; i < res.length; i++) {
					localStorage.setItem(i, JSON.stringify(res[i]));
				}
				location.href = '/checkout/';
			}
		}
		else if (!response.ok){
			$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>${ res.status }
						</div>`);
		}	
	} 
	catch (error) {
		$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
						</div>`);
	}
	finally {
		reset();
	}
};

//validate inputs with regex
const isAddressValidated = (form) => {
	let val = true;
	for(let i = 0; i < form.length; i++){
		if (form[i].value == ""){
			form[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			form[i].classList.add('wrong');
			val = false;
		}
		else if (/[^α-ωίϊΐόάέύϋΰήώΑ-Ωa-zA-Z0-9\-\s]/.test(form[i].value)) { //validate special chars
			form[i].closest(".group").querySelector('.text-danger').style.display = 'block';
			form[i].closest(".group").querySelector('.text-danger').innerHTML = "Δεν είναι έγκυρο αυτό που συμπλήρωσες";
			form[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};

let noDuplicateAddress = () => {
	for(let key in addresses){
		if (addresses[key].address === address.value) {
			$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>Η διεύθυνση αυτή υπάρχει ήδη.
							</div>`);
			return false;
		}
	}
	return true;
};

//reset the loader
const reset = () => {
	loader.style.display = "none";
	blurred.style.display = "none";
	$('body').removeClass('stop-scrolling');
};