var myDatepicker = $('.js-datepicker').datepicker({
    range: false,
    showEvent: 'click',
    onSelect: function onSelect(formattedDate, date, inst) {

        $.ajax({
            url: '/ajax/order-time/',
            method: 'POST',
            data: {
                date: formattedDate
            },
            success: function (data) {
                $('.order-time-wrap').html(data);
            }
        });

        inst.hide();
    }
});

$(document).on('click', '.order-time__item', function (e) {
    var $this = $(this);
    $('.order-time__item').each(function () {
        $(this).removeClass('active');
    });
    $(this).addClass('active');


    $('.order-time-input').val($this.data('value'));
});