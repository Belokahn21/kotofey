$(document).ready(function () {
	var favorite_element = $('.add-to-favorite');
	var product_id = favorite_element.data('product');

	favorite_element.click(function (e) {
		$.ajax({
			url: '/ajax/add-to-favorite/' + product_id + '/',
			success: function (data) {
				if (data == 1) {
					favorite_element.find('.fa-heart').toggleClass('far fas');
				}
			},
			complete: function (data) {

			},
			done: function (data) {

			}
		});
	});
});

