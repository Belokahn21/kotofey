$(document).ready(function () {
    $.fn.deliveryCalc = function () {
        var $form = $(this);

        $('body').on("change", ".delivery-calc-select-tk", function () {
            console.log("select");
            $form.submit();
        });
    };

    $(".delivery-calc-wrap form").deliveryCalc(); // Makes all the links green.
});