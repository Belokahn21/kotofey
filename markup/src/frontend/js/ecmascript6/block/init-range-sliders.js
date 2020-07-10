import $ from 'jquery';

var slider = require('ion-rangeslider');

window.$ = window.jQuery = $.noConflict();
// window.ionRangeSlider = ionRangeSlider;

let inputs = [
	document.querySelector('#js-filter-from'),
	document.querySelector('#js-filter-to'),
];

$(".filter-catalog__range").ionRangeSlider({
	skin: "round",
	type: "double",
	min: 0,
	max: 10000,
	from: 5000,
	to: 8000,
	hide_min_max: true,
	hide_from_to: true,
	onStart: function (data) {
		inputs[0].value = data.from;
		inputs[1].value = data.to;
	},
	onChange: function (data) {
		inputs[0].value = data.from;
		inputs[1].value = data.to;
	},
	onFinish: function (data) {
	},
	onUpdate: function (data) {
	}
});
