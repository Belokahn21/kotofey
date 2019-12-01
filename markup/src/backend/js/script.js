//= lib/init

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

    $('.pre-load-catalog').catalogLoader();

});


(function ($) {

    var options = {
        name: $('#product-name'),
        price: $('#id-price'),
        purchase: $('#id-purchase'),
        count: $('#product-count'),
        description: $('#product-description'),
        vitrine: $('#product-vitrine input'),
        active: $('#product-active input'),
        code: $('#product-code'),
        weight: $('#product-properties-2'),
    };

    $.fn.catalogLoader = function () {
        this.change(function (e) {
            var url = $(this).val();

            if (url.length > 0) {
                $.ajax({
                    url: '/ajax/loader/',
                    method: 'POST',
                    data: {
                        url: url
                    },
                    beforeSend: function () {
                        $('.pre-load-catalog-wrap .backend-preloader').removeClass('hide');
                    },
                    success: function (data) {
                        var product = $.parseJSON(data);
                        for (var key in product) {
                            if (options[key].length > 0) {
                                options[key].val(product[key]);
                            }
                        }
                    },
                    complete: function () {
                        $('.pre-load-catalog-wrap .backend-preloader').addClass('hide');
                    }
                });
            }
        });
    };
})(jQuery);