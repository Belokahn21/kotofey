$(document).ready(function () {
    $('.carousel').carousel();
    $('[data-toggle="tooltip"]').tooltip();

    /* установить активный класс первому элементу --- начало */
    $('.breadcrumb').find('.breadcrumb__step').eq(0).addClass('breadcrumb__step--active');
    /* установить активный класс первому элементу --- конец */


    /* показать выпдающее меню --- начало */
    $('.menu-controller').click(function (e) {
        $('.full-menu-wrap').toggleClass('hide');
    });
    /* показать выпдающее меню --- конец */

    /* Маска телефона X (XXX) XXX XX-XX */
    $('.phone_mask').text(function (i, text) {
        return text.replace(/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 ($2) $3 $4-$5');
    });

    /* Скрытие placeholder элемента */
    var placeholder = "";
    $("input[type=text]").click(function () {
        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', "");
    }).blur(function () {
        $(this).attr('placeholder', placeholder);
        placeholder = "";
    });

});