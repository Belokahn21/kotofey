(function ($) {
	var methods = {
		init: function (options) {
		},
		show: function () {
			// ПОДХОД
		},
		hide: function () {
			// ПРАВИЛЬНЫЙ
		},
		update: function (content) {
			// !!!
		}
	};
	$.fn.catalogFilter = function (method) {
		var $this = this;

		this.find("input, select").each(function () {

			$(this).change(function () {

				$.ajax({
					'url': location.href + '?' + $this.serialize(),
					'method': 'get',
					beforeSend: function () {
						$('.pagination-wrap').html("");


						$('.catalog-list').addClass('flex-position-center').html($('<li>', {
							css: {
								'align-self': 'flex-start'
							}
						}).html($('<img>', {
							src: '/web/upload/images/loading.gif'
						})));
					},
					success: function (data) {

						setTimeout(function () {

							var $page = $(data);

							$('.catalog-list').removeClass('flex-position-center').html("");

							$page.find('.catalog-list').find('.catalog-list__item').each(function () {
								$('.catalog-list').append($(this));
							});
							$('.pagination-wrap').html($page.find('.pagination'));

						}, 2500);

					}
				});

				// $.post("/ajax/filter/", $this.serialize(), function (data) {
				//     console.log(data);
				// }, "JSON");
			});
		});

		// логика вызова метода
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Метод с именем ' + method + ' не существует для catalog filter');
		}
	};
})(jQuery);