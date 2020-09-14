//Clear forms on refresh or redirect back
$(document).ready(function () {
	$('form').each(() => this.reset());
});

$(".collapse").on('show.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-plus fa-minus'); 
});
$(".collapse").on('hide.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-minus fa-plus'); 
});

function noneSugar(id){
	document.getElementById("no"+id).onclick = function(){
		var sugarTypes = document.getElementsByName("sugarType_"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = true;
			sugarTypes[i].checked = false;
		}
	}
}

function uncheck(id){
	document.getElementById("s"+id).onclick = function(){
		var sugarTypes = document.getElementsByName("sugarType_"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = false;
		}
	}
	document.getElementById("m"+id).onclick = function(){
		var sugarTypes = document.getElementsByName("sugarType_"+id);
		for (let i = 0; i < sugarTypes.length; i++){
			sugarTypes[i].disabled = false;
		}
	}
}