$(document).ready(function () {
    var $input = $('.product-detail-calc-count');
    var $plus = $('.product-detail-calc-plus');
    var $minus = $('.product-detail-calc-min');


    $('.product-detail-calc-plus, .product-detail-calc-min').click(function () {
        var count = $input.val();
        if (count === undefined || isNaN(parseInt(count))) {
            $input.val(1);
        }
    });

    $plus.click(function (e) {
        var count = parseInt($input.val());
        var $this = $(this);

        addBasket($this.data('product'), count + 1).done(function (data) {
            if (data == 1) {
                $input.val(count + 1);
            }
        });
    });

    $minus.click(function (e) {
        var count = parseInt($input.val());
        var $this = $(this);


        if (count - 1 === 0) {
            removeFromBasket($this.data('product')).done(function (data) {
                if (data == 1) {
                    $('.product-button.product-add-basket').toggleClass('hide');
                    $('.product-detail-calc-wrap').toggleClass('hide');
                }
            });
            return false;
        }

        if (count === 0) {
            return false;
        }

        addBasket($this.data('product'), count - 1).done(function (data) {
            if (data == 1) {
                $input.val(count - 1);
            }
        });
    });

    $('.product-button.product-add-basket').click(function (e) {
        var $this = $(this);
        var product_id = $(this).data('product');

        addBasket(product_id, 1).done(function (data) {
            if (data == 1) {
                $this.toggleClass('hide');
                $('.product-detail-calc-wrap').toggleClass('hide');
            }
        });

    });

    function addBasket(product_id, count) {
        return $.ajax({
            url: '/ajax/add-to-basket/' + product_id + '/' + count + '/',
            async: true,
            success: function (data) {
            },
            complete: function (data) {

            }
        });
    }

    function removeFromBasket(product_id) {
        return $.ajax({
            url: '/ajax/remove-from-basket/' + product_id + '/',
            async: true,
            success: function (data) {
            },
            complete: function (data) {

            }
        });
    }

});

