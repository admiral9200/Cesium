//Clear forms on refresh or redirect back
$('form').each(function() { this.reset() });

$(".collapse").on('show.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-plus fa-minus'); 
});
$(".collapse").on('hide.bs.collapse', function(){
	$(this).prev('.card-header').find('svg').toggleClass('fa-minus fa-plus'); 
});