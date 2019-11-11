$(document).ready(function () {
    $('.carousel').carousel();
    $('[data-toggle="tooltip"]').tooltip()

    /* установить активный класс первому элементу --- начало */
    $('.breadcrumb').find('.breadcrumb__step').eq(0).addClass('breadcrumb__step--active');
    /* установить активный класс первому элементу --- конец */


    /* показать выпдающее меню --- начало */
    $('.menu-controller').click(function (e) {
        $('.full-menu-wrap').toggleClass('hide');
    });
    /* показать выпдающее меню --- конец */

});