import '../reactjs/components/sidebar';
import '../reactjs/components/statistic';

import 'popper.js';
import 'bootstrap';

import './block/order-load-product';

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
	buttonToggleSlider.addEventListener('click', (event) => {
		let sideElement = document.querySelector('.left-sidebar-container');

		if (sideElement) {
			sideElement.classList.toggle('is-active');
		}
	});
}