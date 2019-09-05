$(document).ready(function () {
    $.fn.configurator = function () {
        var $form = $(this);

        // $('body').on("change", "select, input", function () {
        //     console.log("select");
        //     $form.submit();
        // });
    };

    $(".cfg-form").configurator(); // Makes all the links green.
});