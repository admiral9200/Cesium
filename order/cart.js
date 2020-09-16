function plus(count){
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../php/cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "qty=plus&counter=" + count;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
			else{
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
		}
	}
	xhr.send(params);
}

function minus(count){
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../php/cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "qty=minus&counter=" + count;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
			else{
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
		}
	}
	xhr.send(params);
}

function deleteCoffee(code){
	loader.style.display = "block";
	blurred.style.display = "block";
	$('body').addClass('stop-scrolling');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../php/cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var params = "count=" + code;
	xhr.onload = function(){
		if(this.status == 200){
			if(this.responseText == true){
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
			else{
				document.getElementById('false').innerHTML = this.responseText;
				$("#cart").load("view_cart.php");
				$('form').each(function() { this.reset() });
				loader.style.display = "none";
				blurred.style.display = "none";
				$('body').removeClass('stop-scrolling');
			}
		}
	}
	xhr.send(params);
}