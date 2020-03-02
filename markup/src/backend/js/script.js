//= lib/init

//= include/catalog-loader
//= include/left-menu


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

    /* подрузка товаров в заказе админки -- старт */
    var timeoutLoadInfo = null;
    $('.load-product-info').keyup(function () {
        var timeout = 400;
        var $this = $(this);
        var product_id = $this.val();

        if (timeoutLoadInfo) {
            clearTimeout(timeoutLoadInfo);
        }

        timeoutLoadInfo = setTimeout(function () {
            $.ajax({
                url: '/rest/product/get/' + product_id + '/',
                method: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    var product = JSON.parse(data);
                    updateFields($this.closest('.orders-items-item'), product);
                }
            });
        }, timeout);

    });

    /* подрузка товаров в заказе админки -- конец */
    function updateFields($parent, product) {
        var $name = $parent.find('.load-product-info__name');
        var $price = $parent.find('.load-product-info__price');
        var $count = $parent.find('.load-product-info__count');

        $name.val(product.name);
        $price.val(product.price);
        $count.val(1);
    }
});

var myDatepicker = $('.js-datepicker').datepicker({
    range: false,
    showEvent: 'click',
    onSelect: function onSelect(formattedDate, date, inst) {
        inst.hide();
    }
});