document.querySelectorAll('.filter-catalog__arrow').forEach((callbackElement) => {

	callbackElement.addEventListener('click', (event) => {

		let element = event.target;

		if (callbackElement !== element) {
			element = element.parentElement;
		}

		element.classList.toggle('is-active');
		document.querySelector('.filter-catalog-container').classList.toggle('is-active');
	});
});