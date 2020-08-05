document.querySelectorAll('.js-basket-remove').forEach((callbackElement) => {

	callbackElement.addEventListener('click', (event) => {

		let element = event.target;

		if (callbackElement !== element) {
			element = element.parentElement;
		}

		let product_id = element.getAttribute('data-product-id');
		let parent = element.parentElement;

		if (parseInt(product_id) <= 0) {
			return false;
		}

		//todo: send ajax to rest for remove element from session basket

		parent.remove();
	});

});
