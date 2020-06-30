import search from '../reactjs/components/sidebar';

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
	buttonToggleSlider.addEventListener('click', (event) => {
		let sideElement = document.querySelector('.left-sidebar-container');

		if (sideElement) {
			sideElement.classList.toggle('is-active');
		}
	});
}