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

$('.order-time__item').click(function (e) {
    $('.order-time__item').each(function () {
        $(this).removeClass('active');
    });
    $(this).addClass('active')
});