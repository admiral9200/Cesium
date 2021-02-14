const doorname = document.getElementById('doorname');
const floor = document.getElementById('floor');
const loader = document.getElementById("loader");
const blurred = document.getElementById("blurred");

(() => {
	let finalCart = '', totalCost = 0;

	if (localStorage.length > 0){

		let keys = Object.keys(localStorage);
		keys = keys.map(key => parseInt(key)).sort((a, b) => a - b);

		for (let i = 0; i < localStorage.length; i++) {

			let coffeeToOrder = localStorage.getItem(keys[i]);
			coffeeToOrder = JSON.parse(coffeeToOrder);

			try {
				let price = parseFloat(coffeeToOrder.price);

				finalCart += `<li class='list-group-item d-flex justify-content-between lh-condensed'>
									<div>
										<h6 class='my-0'>${ coffeeToOrder.qty }x ${ coffeeToOrder.coffee }</h6>
										<small class='text-muted'>
											${coffeeToOrder.sugar}
											${coffeeToOrder.sugarType !== '' ? ', ' + coffeeToOrder.sugarType : ''}
											${coffeeToOrder.milk === 1 ? ', Γάλα' : ''}
											${coffeeToOrder.cinnamon === 1 ? ', Κανέλα' : ''}
											${coffeeToOrder.choco === 1 ? ', Σκόνη Σοκολάτας' : ''}
										</small>
									</div>
									<span class='text-muted'>${ price.toFixed(2) }€</span>
								</li>`;
				
				totalCost += price;
			}
			catch (err){
				console.error(err);
			}
		}

		finalCart += `<li class="list-group-item d-flex justify-content-between">
						<h5>Κόστος</h5>
						<h5>${ totalCost.toFixed(2) }€</h5>
					</li>`;

		$("#FinalCart").append(finalCart);
	}
	else {
		location.href = '/order/';
	}
})
();

let input = [doorname, floor];
for(let i = 0; i < input.length; i++){
	input[i].addEventListener('keyup', function () {
		this.closest("#input").querySelector('.text-danger').style.display = 'none';
		this.classList.remove("wrong");
		if (this.value == '') {
			this.closest("#input").querySelector('.text-danger').style.display = 'block';
			this.classList.add("wrong");
		}
	});
}

const isValidatedCheckout = () => {
	let val = true;
	let orderAttr = [doorname, floor];
	let payment = document.querySelectorAll('input[name="payment"]:checked');
	if (Object.keys(payment).length === 0){
		document.getElementById('payment').style.display = 'block';
		$("label[class='form-check-label'").addClass("wrong");
		val = false;
	}
	for(let i = 0; i < orderAttr.length; i++){
		if(orderAttr[i].value == ""){
			orderAttr[i].closest("div").querySelector('.text-danger').style.display = 'block';
			orderAttr[i].classList.add('wrong');
			val = false;
		}
	}
	return val;
};

let sendOrder = async () => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');

	try {
		if (isValidatedCheckout()){
		
			let payment = document.querySelector('input[name="payment"]:checked');
			let phone = document.getElementById('phone').value;
			let comment = document.getElementById('comment').value;
	
			if (doorname.value && floor.value && payment) {
	
				//populate the json data for request in server
				let cartData = {};
	
				for (let i = 0; i < localStorage.length; i++) {
					cartData['_cc' + i] = localStorage[i];
				}
				cartData['payment'] = payment.value;
				cartData['doorname'] = doorname.value;
				cartData['floor'] = floor.value;
				cartData['phone'] = phone;
				cartData['comment'] = comment;

				let response = await fetch('checkout.php', {
					method: "POST",
					body: JSON.stringify(cartData),
					headers: {
						"Content-type": "application/json; charset=UTF-8"
					}
				});
	
				if (response.ok) {
					let res = await response.json();
	
					if (res === 'success'){
	
						showCompleteOrder();
						localStorage.clear();
					}
					else if (res === 'fail'){
	
						$("#false").addClass('my-2');
						$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
											<button type='button' class='close' data-dismiss='alert'>&times;</button>Προέκυψε σφάλμα στην αποστολή παραγγελίας. Δοκίμασε ξανά.
										</div>`);
					}
				}
			}
		}
	}
	catch (error) {
		$("#false").addClass('my-2');
		$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
						</div>`);
	}
	finally{
		loader.style.display = "none";
		blurred.style.display = "none";
		$('body').removeClass('stop-scrolling');
	}
};

let showCompleteOrder = async () => {

	try {
		let response = await fetch('checkout.php');
		if (response.ok) {
			let orderDetails = await response.json();

			$("#orderCompletion").empty().html(`<div class="p-xl-0 p-lg-0 p-md-0 p-sm-4 p-4">
													<div class="alert alert-success" role="alert">
														<div class="text-center">
															<img src="/images/success.png" class="rounded chk" alt="Success">
														</div>
														<h1 class="alert-heading text-center">Η παραγγελία σου θα παραδοθεί σε 15'</h1>
														<p class="text-center chk-p">Στο email σου θα βρεις όλα τα στοιχεία της παραγγελίας σου. Σε περίπτωση που θέλεις να αλλάξεις κάτι, κάλεσε μας.</p>
														<hr>
														<div class="container-fluid ">
															<div class="row">
																<div class="col-xl-6 col-12 pl-xl-4 pr-xl-4 p-0 text-center">
																	<h5>Διεύθυνση Παράδοσης</h5>
																	<p>${orderDetails[0].address} - ${orderDetails[0].floor}ος όροφος</p>
																</div>
																<div class="col-xl-6 col-12 pl-xl-4 pr-xl-4 p-0 text-center">
																	<h5>Ώρα Παραγγελίας</h5>
																	<p>${orderDetails[0].time}</p>
																</div>
															</div>
														</div>
													</div>
												</div>`);
		}
		else{
			$("#false").addClass('my-2');
			$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>${ response.status }
							</div>`);
		}	
	}
	catch (error) {
		$("#false").addClass('my-2');
		$("#false").html(`<div class='alert alert-danger alert-dismissible fade show'>
							<button type='button' class='close' data-dismiss='alert'>&times;</button>${ error }
						</div>`);
	}
	finally{
		loader.style.display = "none";
		blurred.style.display = "none";
		$('body').removeClass('stop-scrolling');
	}
};