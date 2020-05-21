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
        vendor_id: $('#product-vendor_id'),
        country: $('#product-properties-6'),
        model: $('#product-properties-1'),
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