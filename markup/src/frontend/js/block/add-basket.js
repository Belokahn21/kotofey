let oldSrcValue = "";

document.querySelectorAll('.js-add-basket').forEach((forEachElement) => {

	forEachElement.addEventListener('click', (event) => {
		let element = event.target;

		if (forEachElement !== element) {
			element = element.parentElement;
		}
		toggleIcon(element);
		toggleText(element, 'Добавлено')
	});

});

function toggleIcon(element) {
	let image = element.querySelector('.add-basket__icon');

	oldSrcValue = image.getAttribute('src');
	image.setAttribute('src', './assets/images/arrow-success.png');
}

function toggleText(element, text) {
	element.querySelector('.add-basket__label').textContent = text;
}
