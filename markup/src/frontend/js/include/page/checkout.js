$(document).ready(function () {
    $('.type-order-item:not(.no-hover)').click(function () {
        var type = $(this).data('order-type');
        $('.order-type-form-wrap').find('.order-type-form').css('display', 'none');
        $('.order-type-form-wrap').find('.order-type-form.' + type).css('display', 'flex');
    });
});