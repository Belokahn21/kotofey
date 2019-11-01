$(document).ready(function () {

	$('.phone_mask').text(function (i, text) {
		return text.replace(/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 ($2) $3 $4-$5');
	});

	var placeholder = "";
	$("input[type=text]").click(function () {

		placeholder = $(this).attr('placeholder');
		$(this).attr('placeholder', "");

	}).blur(function () {

		$(this).attr('placeholder', placeholder);
		placeholder = "";

	});
});