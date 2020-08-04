import $ from 'jquery';

window.$ = window.jQuery = $;

import '../reactjs/components/sidebar';
import '../reactjs/components/statistic';
import '../reactjs/components/todo';

import 'popper.js';
import 'bootstrap';

import './block/order-load-product';
import './block/phone-mask';
import './block/notify';
import './include/other-jquery';
import './include/maskedinput';

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
	buttonToggleSlider.addEventListener('click', (event) => {
		let sideElement = document.querySelector('.left-sidebar-container');

		if (sideElement) {
			sideElement.classList.toggle('is-active');
		}
	});
}