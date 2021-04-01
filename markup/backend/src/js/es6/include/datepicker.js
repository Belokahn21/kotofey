// this now 05.10.2020 is worked!
import 'air-datepicker';

if ($('.js-datepicker').length > 0) {
    var myDatepicker = $('.js-datepicker').datepicker({
        range: false,
        showEvent: 'click',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    });
}