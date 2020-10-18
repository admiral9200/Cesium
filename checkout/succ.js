/*jshint esversion: 6 */
let getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '../php/base.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			prof = JSON.parse(this.responseText);
			document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
		}
	};
	xhr.send();
};

(() => getProfile())();

let getOrderDetails = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', 'checkout.php', true);
	xhr.onload = function(){
		if (this.status == 200) {
			let orderDetails = JSON.parse(this.responseText);
			console.log(orderDetails);
			document.getElementById('details').innerHTML = `${orderDetails[0].address} - ${orderDetails[0].floor}ος όροφος`;
			document.getElementById('time').innerHTML = `${orderDetails[0].time}`;
		}
		else if(this.status == 200 && this.responseText == false){

		}
	};
	xhr.send();
};

(() => getOrderDetails())();