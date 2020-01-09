$(document).ready(function () {
	var $input_amount_weight = $('.select-weight-form__amount');

	var stop_timer = null;
	$input_amount_weight.change(function (e) {

		var $input_product_id = $('.select-weight-form__product-id');
		var $price = $('.buy-weight__price');

		var product_id = $input_product_id.val();
		var amount_weight = $input_amount_weight.val();

		if (stop_timer) {
			clearTimeout(stop_timer);
		}

		stop_timer = setTimeout(function () {
			$.ajax({
				url: '/ajax/buy-weight/',
				method: 'POST',
				data: {
					product_id: product_id,
					weight: amount_weight
				},
				success: function (data) {
					data = JSON.parse(data);
					$price.html(data.summary_price);
				}
			});
		}, 100);
	});


});

