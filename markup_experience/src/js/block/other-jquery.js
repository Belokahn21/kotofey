import $ from 'jquery';

window.$ = window.jQuery = $;

let Selectize = require('selectize');

$('.js-selectize').selectize({
    create: true,
    onChange: function () {
        let url = new URL(location.href);
        let params = url.searchParams

        params.set("sort", arguments[0]);

        url.search = params.toString();

        location.href = decodeURIComponent(url.toString());
    }
});

$('.modal').on('show.bs.modal', function () {
    $('.modal').modal('hide');
});

$(document).ready(function () {
    let $toast = $('.toast');
    if ($toast) $toast.toast('show');

    $("[rel='tooltip']").tooltip();

    $('.filter-catalog-checkboxes').on('hidden.bs.collapse', function (e) {
        $('a[href="#' + $(this).attr('id') + '"]').text("Показать");
    }).on('shown.bs.collapse', function (e) {
        $('a[href="#' + $(this).attr('id') + '"]').text("Скрыть");
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#button-up').fadeIn();
        } else {
            $('#button-up').fadeOut();
        }
    });

    $('#button-up').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});