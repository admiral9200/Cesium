/*jshint esversion: 6 */
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