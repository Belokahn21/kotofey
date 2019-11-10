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
        $input.val(count + 1);
    });

    $minus.click(function (e) {
        var count = parseInt($input.val());

        if (count === 1) {
            return false;
        }

        $input.val(count - 1);
    });


    $('.product-button.product-add-basket').click(function (e) {
        $(this).toggleClass('hide');
        $('.product-detail-calc-wrap').toggleClass('hide');
    });
});

