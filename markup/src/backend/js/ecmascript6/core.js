import search from '../reactjs/components/search';

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
	buttonToggleSlider.addEventListener('click', (event) => {
		let sideElement = document.querySelector('.left-side');

		if (sideElement) {
			sideElement.classList.toggle('is-active');
		}
	});
}