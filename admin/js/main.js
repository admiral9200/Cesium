$(document).ready(function(){    
	loadstation();
});

function loadstation(){
	$("#liveOrders").load("./php/liveOrders.php");
	setTimeout(loadstation, 1000);
}