$(document).ready(function () {
    $('.product-detail-calc-form').cartCalc();


    $('.product-button.product-add-basket').click(function (e) {
        var $this = $(this);
        var product_id = $(this).data('product');

        addBasket(product_id, 1).done(function (data) {
            if (data == 1) {
                $this.toggleClass('hide');
                $this.next('.product-detail-calc-wrap').toggleClass('hide');
            }
        });

    });
});

jQuery.fn.cartCalc = function () {
    this.each(function () {
        var $this = $(this);
        var $elementPlus = $(this).find('.product-detail-calc-plus');
        var $elementMinus = $(this).find('.product-detail-calc-min');
        var $input = $(this).find('.product-detail-calc-count');

        $elementPlus.click(function () {
            var count = $input.val();
            if (count === undefined || isNaN(parseInt(count))) {
                $input.val(1);
            }
        });

        $elementMinus.click(function () {
            var count = $input.val();
            if (count === undefined || isNaN(parseInt(count))) {
                $input.val(1);
            }
        });

        $elementPlus.click(function (e) {
            var product_id = $(this).data('product');
            var count = parseInt($input.val());
            e.preventDefault();
            addBasket(product_id, count + 1).done(function (data) {
                if (data == 1) {
                    $input.val(count + 1);
                }
            });
        });
<<<<<<< HEAD

        $elementMinus.click(function (e) {
            var product_id = $(this).data('product');
            var count = parseInt($input.val());
            e.preventDefault();

            if (count - 1 === 0) {
                removeFromBasket($(this).data('product')).done(function (data) {
                    if (data == 1) {
                        $this.parent().siblings('.product-button.product-add-basket').toggleClass('hide');
                        $this.parent().toggleClass('hide');
                    }
                });
                return false;
=======
    });

    $('.product-button.product-add-basket').click(function (e) {
        var $this = $(this);
        var product_id = $(this).data('product');

        addBasket(product_id, 1).done(function (data) {
            if (data == 1) {
                $this.toggleClass('hide');
                $('.product-detail-calc-wrap').toggleClass('hide');
>>>>>>> markup
            }

            if (count === 0) {
                return false;
            }

            addBasket(product_id, count - 1).done(function (data) {
                if (data == 1) {
                    $input.val(count - 1);
                }
            });
        });
    });
};

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