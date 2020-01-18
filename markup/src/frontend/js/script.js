//= lib/init
//= include/init

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

    /* В разделе каталога при нажатии кнопки "Показать фильтр" -- начало */
    $('.show-catalog-filter.switcher').click(function (e) {
        var $filter = $('.filter');
        if ($filter.css('display') === 'none') {
            $filter.css('display', 'block');
        } else {
            $filter.css('display', 'none');
        }
    });
    /* В разделе каталога при нажатии кнопки "Показать фильтр" -- конец */

    /* Выбор города в попапе - начало */
    $('.city__item-link').click(function (e) {
        var $this = $(this), city_id = $this.data('city-id');
        $.ajax({
            url: '/ajax/set-city-id/',
            data: {
                id: city_id
            },
            success: function (data) {
                if (data === '1') {
                    location.reload();
                }
            },
            error: function (data) {

            }
        });
    });
    /* Выбор города в попапе - конец */

    /* Скрытие placeholder элемента */
    var placeholder = "";
    $("input[type=text], textarea").click(function () {
        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', "");
    }).blur(function () {
        $(this).attr('placeholder', placeholder);
        placeholder = "";
    });

    /* Обновление времени в полоске панели управления в публичке - начало */
    if ($('.admin-panel-list__item-ts').length > 0) {
        setInterval(function () {
            $('.admin-panel-list__item-ts').text(Math.floor(Date.now() / 1000));
        }, 1000);
    }
    /* Обновление времени в полоске панели управления в публичке - конец */

    /* принятие согласия о куках, пишем в сессию - начало */
    $('.cookie__button').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: '/ajax/accept-cookie/',
            success: function (data) {
                if (data === '1') {
                    $('.cookie').remove();
                }
            }
        });
    }).hover(function () {
        $(this).find('span').toggleClass('hide'); // небольшая юзабильность- меняем слово с "Понял" на "Закрыть"
    });
    /* принятие согласия о куках, пишем в сессию - конец */


    $('.carousel.carousel-multi-item.v-2 .carousel-item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < 4; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
        }
    });


    /* Скрытие уведомления -- начало */
    $(document).ready(function () {
        setTimeout(function () {
            $(".alert-notify-wrap").slideUp();
        }, 2500);
    });
    /* Скрытие уведомления -- конец */


    $('.filter-variant__item').click(function (e) {
        var $this = $(this), display = $this.data('show'), $catalog = $('.catalog-list');

        $('.filter-variant__item').each(function () {
            $(this).removeClass('active');
        });

        $this.addClass('active');

        $catalog.removeClass('list');
        $catalog.addClass(display);
    });


    var myDatepicker = $('.js-datepicker').datepicker({
        range: false,
        showEvent: 'click',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    });
});