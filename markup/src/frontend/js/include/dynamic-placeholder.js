$(document).ready(function () {
    var placeholder = "";
    $("input[type=text], textarea").click(function () {

        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', "");

    }).blur(function () {

        $(this).attr('placeholder', placeholder);
        placeholder = "";

    });
});