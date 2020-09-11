// he include from app with script tag before include backend.min.js
document.addEventListener('load', () => {
    var myDatepicker = $('.js-datepicker').datepicker({
        range: false,
        showEvent: 'click',
        onSelect: function onSelect(formattedDate, date, inst) {
            inst.hide();
        }
    });
});
