import '../reactjs/components/sidebar';
import '../reactjs/components/statistic';
import '../reactjs/components/todo';

import 'popper.js';
import 'bootstrap';

import datepicker from 'js-datepicker';
import Inputmask from "maskedinput";

import './block/order-load-product';
import './block/notify';

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
	buttonToggleSlider.addEventListener('click', (event) => {
		let sideElement = document.querySelector('.left-sidebar-container');

		if (sideElement) {
			sideElement.classList.toggle('is-active');
		}
	});
}

let jsDatePicker = document.querySelector('.js-datepicker');
if (jsDatePicker) {
	const picker = datepicker(jsDatePicker)
}

let elements = document.querySelectorAll('.js-phone-mask');

if (elements) {
	elements.forEach((element) => {
		element.textContent = element.textContent.replace(/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 ($2) $3 $4-$5');
	});
}

let russsianPhone = document.querySelector(".js-mask-ru");
if (russsianPhone) {
	let im = new Inputmask("+7 (999) 999 99-99", {placeholder: "+7 (___) ___ __ __"});
	im.mask(russsianPhone);
}