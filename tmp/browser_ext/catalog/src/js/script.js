//= lib/init
//= include/init

$(document).ready(function () {
	$('.catalog__item .basket__price').mouseover(function () {
		$(this).find('div').toggleClass('hide');
		return false;
	});

	/* Маска телефона X (XXX) XXX XX-XX */
	$('.phone_mask').text(function (i, text) {
		return text.replace(/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
	});
});
