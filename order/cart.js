let quantity = (count, qty) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "qty=" + qty + "&counter=" + count;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php", () => resetForms());
			}
			else{
				document.getElementById('false').classList.add("mt-3");
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php", () => resetForms());
			}
		}
	}
	xhr.send(params);
};

let deleteCoffee = (code) => {
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "count=" + code;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php", () => resetForms());
			}
			else{
				document.getElementById('false').classList.add("mt-3");
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php", () => resetForms());
			}
		}
	}
	xhr.send(params);
};