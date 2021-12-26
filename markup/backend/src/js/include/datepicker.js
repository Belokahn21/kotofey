// this now 05.10.2020 is worked!
import 'air-datepicker';

let $obj = $('.js-datepicker');
if ($obj.length > 0) {
    $obj.datepicker({
        range: false,
        showEvent: 'click',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    });
}
let $obj2 = $('.js-datepicker-as-datetime');
if ($obj2.length > 0) {
    $obj2.datepicker({
        range: false,
        showEvent: 'click',
        dateFormat: 'yyyy-mm-dd',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    });
}