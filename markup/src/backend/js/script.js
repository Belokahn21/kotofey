//= lib/init

//= include/catalog-loader


$(document).ready(function () {
    /* Скрытие placeholder элемента */
    var placeholder = "";
    $("input[type=text], textarea").click(function () {
        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', "");
    }).blur(function () {
        $(this).attr('placeholder', placeholder);
        placeholder = "";
    });

    /* Показывать модалку если она есть -- старт */
    if ($('#update-task').length > 0) {
        $('#update-task').modal('show');
    }
    /* Показывать модалку если она есть -- конец */

    /* Запуск своих плагинов -- старт */
    $('.pre-load-catalog').catalogLoader();
    /* Запуск своих плагинов -- конец */

    /* закрыть уведомление -- начало */
    $('.notify__close').click(function () {
        $('.notify').remove();
    });
    /* закрыть уведомление -- конец */

    /* поаказать меню -- начало */
    $('.switch-menu').click(function () {
        $('.dashboard-left-sidebar').toggle();
    });
    /* поаказать меню -- конец */

    $('[data-toggle="tooltip"]').tooltip();


    /* реплейсер - старт */
    $('#feed-replace').change(function () {
        var $this = $(this);

        var current_text = $this.val();
        $this.val(current_text.replace(/\t/g, ', '));

        current_text = $this.val();
        $this.val(current_text.replace(/, , /g, ', '));

        current_text = $this.val();
        $this.val(current_text.replace(/0, /g, ''));
    });
    /* реплейсер - конец */
});

