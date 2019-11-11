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

    // старый метод
    $('.add-basket').click(function (e) {
        e.preventDefault();
        var $element = $(this);
        $.post("/ajax/tobasket/", {id: $element.data('id')}, function (data) {
            if (data.status == true) {
                $('.basket__summary').html(data.htmlData);
                // $element.css('background', 'green');
                // $element.css('border', '1px green solid');
                // $element.children('i').toggleClass('fa-shopping-cart fa-check');
            }
        }, "JSON");
    });


    // $('.product-button.product-add-basket').click(function (e) {
    //     var $this = $(this);
    //     var product_id = $(this).data('product');
    //
    //     addBasket(product_id, 1).done(function (data) {
    //         if (data == 1) {
    //             $this.toggleClass('hide');
    //             $('.product-detail-calc-wrap').toggleClass('hide');
    //         }
    //     });
    //
    // });

    // function addBasket(product_id, count) {
    //     return $.ajax({
    //         url: '/ajax/add-to-basket/' + product_id + '/' + count + '/',
    //         async: true,
    //         success: function (data) {
    //         },
    //         complete: function (data) {
    //
    //         }
    //     });
    // }

});

