$(document).ready(function () {
	$('.header-navigation__hamburger').click(function (e) {
		$(this).toggleClass('active');
		$('.dropdown-menu-wrap').toggleClass('hide');
	});
});