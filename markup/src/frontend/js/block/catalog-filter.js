import $ from 'jquery';
// window.$ = window.jQuery = $.noConflict();
window.$ = window.jQuery = $;

var $form = $('#filter-form-id');
var $catalog = $('.catalog');
var $paginationWrap = $('.pagination-wrap');
const timeout = 2500;

if ($form) {

    $form.find('input,select').each(function () {
        let element = $(this);

        element.change(function () {
            $.ajax({
                'url': location.search ? location.href + '&' + $form.serialize() : location.href + '?' + $form.serialize(),
                data: $form.serialize(),
                method: 'POST',
                beforeSend: function () {
                    $paginationWrap.html("");

                    $catalog.html($('<li>').html($('<img>', {
                        src: '/upload/images/loading.gif'
                    })));
                },
                success: function (data) {

                    setTimeout(function () {
                        var $page = $(data);

                        $catalog.html("");

                        $page.find('.catalog').find('.catalog__item').each(function () {
                            $catalog.append($(this));
                        });

                        $paginationWrap.html($page.find('.pagination'));

                    }, timeout);

                }
            });
        });

    });
}


// (function ($) {
// 	var methods = {
// 		init: function (options) {
// 		},
// 		show: function () {
// 			// ПОДХОД
// 		},
// 		hide: function () {
// 			// ПРАВИЛЬНЫЙ
// 		},
// 		update: function (content) {
// 			// !!!
// 		}
// 	};
// 	$.fn.catalogFilter = function (method) {
// 		var $this = this;
//
// 		this.find("input, select").each(function () {
//
// 			$(this).change(function () {
//
// 				 $.ajax({
// 				 	'url': location.href + '?' + $this.serialize(),
// 				 	'method': 'get',
// 				 	beforeSend: function () {
// 				 		$('.pagination-wrap').html("");
//
//
// 				 		$('.catalog-list').addClass('flex-position-center').html($('<li>', {
// 				 			css: {
// 				 				'align-self': 'flex-start'
// 				 			}
// 				 		}).html($('<img>', {
// 				 			src: '/upload/images/loading.gif'
// 				 		})));
// 				 	},
// 				 	success: function (data) {
//
// 				 		setTimeout(function () {
//
// 				 			var $page = $(data);
//
// 				 			$('.catalog-list').removeClass('flex-position-center').html("");
//
// 				 			$page.find('.catalog-list').find('.catalog-list__item').each(function () {
// 				 				$('.catalog-list').append($(this));
// 				 			});
// 				 			$('.pagination-wrap').html($page.find('.pagination'));
//
// 				 		}, 2500);
//
// 				 	}
// 				 });
// 			});
// 		});
//
// 		// логика вызова метода
// 		if (methods[method]) {
// 			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
// 		} else if (typeof method === 'object' || !method) {
// 			return methods.init.apply(this, arguments);
// 		} else {
// 			$.error('Метод с именем ' + method + ' не существует для catalog filter');
// 		}
// 	};
// })(jQuery);
//
//
// $("#filter-form-id").catalogFilter();