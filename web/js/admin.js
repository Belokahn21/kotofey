$(document).ready(function () {
    $('.todo-item__remove').click(function (e) {
        var $element = $(this);
        $.post('/ajax/removetodo/', {id: $element.data('id')}, function (data) {
            if (data == 1) {
                $element.parent('.todo-item').slideUp();
            }
        }, 'JSON');
    });

    $('.todo-item__close').click(function (e) {
        var $element = $(this);
        $.post('/ajax/closetodo/', {id: $element.data('id')}, function (data) {
            if (data == 1) {
                $element.find('i').toggleClass('fa-lock fa-lock-open');
            }
        }, 'JSON');
    });


    $(".select-order-user").change(function () {
        $('.new-customer-order input').each(function () {
            $(this).val("");
        });
    });

    $('.new-customer-order input').change().keydown(function () {
        $('.select-order-user  option:selected').prop("selected", false);
    });

    $('.select-items-new-order').change(function () {
        var summ = 0, countries = [];


        $.each($(".select-items-new-order option:selected"), function () {
            var id = $(this).val();
            summ += parseInt(products[id].price);
        });

        $('.order-summ').css('display', 'inline-block');
        $('.order-summ-count').text(summ);

    });

    $('#select-type-settings').change(function () {
        var $this = $(this);
        window.location = '?type=' + $this.val();
    });

    $('#select-type-prop').change(function () {
        var $this = $(this);
        window.location = '?type=' + $this.val();
    });

});
