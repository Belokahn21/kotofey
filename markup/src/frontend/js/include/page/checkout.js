$(document).ready(function () {

    // на странице /checkout/ выбирает вариант заказа
    $('.type-order-item:not(.no-hover)').click(function () {
        var type = $(this).data('order-type');
        $('.order-type-form-wrap').find('.order-type-form').css('display', 'none');
        $('.order-type-form-wrap').find('.order-type-form.' + type).css('display', 'flex');
    });


    // $('.type-order__item').click(function (e) {
    //     var target = $(this).data('checkout');
    //
    //
    //     $('.checkout-order').addClass('hide');
    //     $('.checkout-order[data-type=' + target + ']').removeClass('hide')
    //
    // });


});