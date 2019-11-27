//= lib/init

$(document).ready(function () {
    /* Скрытие placeholder элемента */
    var placeholder = "";
    $("input[type=text], textarea").click(function () {
        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', "");
    }).blur(function () {
        $(this).attr('placeholder', placeholder);
        placeholder = "";
    });

    $('.pre-load-catalog').catalogLoader();

});


(function ($) {
    $.fn.catalogLoader = function () {
        this.change(function (e) {
            var url = $(this).val();


            $.ajax({
                url: '/ajax/loader/',
                method: 'POST',
                data: {
                    url: url
                },
                success: function (data) {
                    console.log(data);
                }
            });
        });
    };
})(jQuery);