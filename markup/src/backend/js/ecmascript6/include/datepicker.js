// he include from app with script tag before include backend.min.js

var targetElement = $('.js-datepicker');

if (targetElement) {
    var myDatepicker = targetElement.datepicker({
        range: false,
        showEvent: 'click',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    });
}
