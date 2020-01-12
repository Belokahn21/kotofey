$(document).ready(function () {
    var $input_amount_weight = $('.select-weight-form__amount');
    var summary_price = 0;
    var pack_price = 0;


    /*---------  расчёт суммы заказа, по весу - старт --------*/
    var stop_timer = null;
    $input_amount_weight.change(function (e) {

        var $input_product_id = $('.select-weight-form__product-id');

        var product_id = $input_product_id.val();
        var amount_weight = $input_amount_weight.val();

        if (stop_timer) {
            clearTimeout(stop_timer);
        }

        stop_timer = setTimeout(function () {
            $.ajax({
                url: '/ajax/buy-weight/',
                method: 'POST',
                data: {
                    product_id: product_id,
                    weight: amount_weight
                },
                success: function (data) {
                    data = JSON.parse(data);
                    summary_price = data.summary_price;
                    setSummaryPrice();
                }
            });
        }, 100);
    });
    /*---------  расчёт суммы заказа, по весу - конец --------*/


    /*------------------  Подсчёт суммы заказа при выборе пакета - начало  --------------------*/
    $('.packaging-list__item').click(function () {
        var $this = $(this);
        var pack_id = $this.data('uniq-product');
        pack_price = parseInt($this.data('price'));

        $('.packaging-list__item').each(function () {
            $(this).removeClass('active');
        });

        $(this).addClass('active');

        if (summary_price !== undefined) {
            setSummaryPrice();
            $('.select-weight-form__pack-id').val(pack_id);
        }
    });
    /*------------------  Подсчёт суммы заказа при выборе пакета - конец  --------------------*/

    function setSummaryPrice() {
        $('.buy-weight__price').html(parseInt(parseInt(summary_price) + pack_price));
    }

});

