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


						$('.catalog-list').html($('<img>', {
							src: '/web/upload/images/loading.gif',
							css: {
								'width': ' 300px',
								'height': ' 300px',
								'align-self': 'center',
								'align-content': 'center'
							}
						}));
					},
					success: function (data) {

						setTimeout(function () {

							var $page = $(data);

							$('.catalog-list').html("");

							$page.find('.catalog-list').find('li').each(function () {
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