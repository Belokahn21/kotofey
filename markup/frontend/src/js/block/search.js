const searchElements = document.querySelectorAll('.js-search-toggle');

if (searchElements) {
	searchElements.forEach((element) => {
		element.addEventListener('click', (event) => {
			const form = document.querySelector('.js-search-form');

			if (!form)  return false;

			form.classList.toggle('is-active');
		});
	});
}