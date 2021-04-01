// this now 05.10.2020 is worked!
import 'air-datepicker';


let jElement = $('.js-datepicker');

if (jElement) {
    let jOptions = {
        range: false,
        showEvent: 'click',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    };

    if (jElement.data('min')) jOptions.minDate = new Date(jElement.data('min'));

    jElement.datepicker(jOptions);
}
