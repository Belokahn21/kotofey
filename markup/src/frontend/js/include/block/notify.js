$(document).ready(function () {
    $('.notify__button').click(function () {
        $.ajax({
            url: '/ajax/hide-notify/',
            method: 'POST',
            success: function (data) {
                $('.notify').remove();
            }
        });
    });
});