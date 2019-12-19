$(document).ready(function () {
	$('.add-to-compare').click(function (e) {
		e.preventDefault();
		var $this = $(this);
		var product_id = $this.data('product');

		$.ajax({
			url: '/ajax/to-compare/' + product_id + '/',
			method: 'POST',
			success: function (data) {
			}
		});
	});
});