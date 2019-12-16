//= lib/init

//= include/catalog-loader


$(document).ready(function () {
	/* Скрытие placeholder элемента */
	var placeholder = "";
	$("input[type=text], textarea").click(function () {
		placeholder = $(this).attr('placeholder');
		$(this).attr('placeholder', "");
	}).blur(function () {
		$(this).attr('placeholder', placeholder);
		placeholder = "";
	});

	/* Показывать модалку если она есть -- старт */
	if ($('#update-task').length > 0) {
		$('#update-task').modal('show');
	}
	/* Показывать модалку если она есть -- конец */

	/* Запуск своих плагинов -- старт */
	$('.pre-load-catalog').catalogLoader();
	/* Запуск своих плагинов -- конец */

	$('[data-toggle="tooltip"]').tooltip();
});

