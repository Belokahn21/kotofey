import $ from 'jquery';
// window.$ = window.jQuery = $.noConflict();
window.$ = window.jQuery = $;

var $form = $('#filter-form-id');
var $catalog = $('.catalog');
var $paginationWrap = $('.pagination-wrap');
const timeout = 2500;
const timeoutAjax = 1000;
let timerEx;

if ($form) {

    $form.find('input,select').each(function () {
        let element = $(this);

        element.change(function () {

            if (timerEx) clearTimeout(timerEx);

            timerEx = setTimeout(function () {
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
            }, timeoutAjax);
        });
    });
}