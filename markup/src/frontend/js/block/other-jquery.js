import $ from "jquery";

let Selectize = require('selectize');

$('.js-selectize').selectize({
	create: true,
});

$('.modal').on('show.bs.modal', function () {
	$('.modal').modal('hide');
});

$(document).ready(function () {
	let $toast = $('.toast');
	if ($toast) {
		$toast.toast('show');
	}
});