$(document).ready(function () {
	$('.inspector__value.window-width').html($(window).width());
	
	$(window).resize(function () {
		$('.inspector__value.window-width').html($(window).width());
	});
});