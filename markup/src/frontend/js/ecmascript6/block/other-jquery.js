import $ from "jquery";

let Selectize = require('selectize');

$('.js-selectize').selectize({
	create: true,
});

$('.modal').on('show.bs.modal', function () {
	$('.modal').modal('hide');
});

// $('#auth-form-signup-id').on('submit', function(e) {
$('#auth-form-signup-id').off('submit').unbind('submit').submit(function (e) {
	console.log('форма регистрации отправлена');
	let $this = $(this);
	e.preventDefault();

	$.ajax({
		url: $this.attr('action'),
		method: 'POST',
		data: $this.serialize(),
		success: function (data) {
			let response = JSON.parse(data);
			console.log(response);
			let toast = '<div role="alert" style="z-index: 9999;position:fixed; left: 0;bottom:0;" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">\n' +
				'  <div class="toast-header">\n' +
				'    <img src="..." class="rounded mr-2" alt="...">\n' +
				'    <strong class="mr-auto">Уведомление</strong>\n' +
				'    <small></small>\n' +
				'    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
				'      <span aria-hidden="true">&times;</span>\n' +
				'    </button>\n' +
				'  </div>\n' +
				'  <div class="toast-body">\n' +
				response.message +
				'  </div>\n' +
				'</div>';
			if (response.code === 500) {
				console.log("error, show toast");
				$('body').append(toast);
				$('.toast').toast('show');
			}
		},
		error: function (data) {

		}
	});

	console.log('форма регистрации отправлена--конец');
	return false;

});