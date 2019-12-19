$(document).ready(function () {
    $('.add-to-compare').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var product_id = $this.data('product');
        var $counter = $('.compare__count span');

        $.ajax({
            url: '/ajax/to-compare/' + product_id + '/',
            method: 'POST',
            success: function (data) {
                data = JSON.parse(data);
                $counter.html(data.other.count);

                toggleIcon();

            }
        });
    });

    function toggleIcon() {
        var $icon = $('.add-to-compare i');

        if ($icon.hasClass('fas') && $icon.hasClass('fa-balance-scale')) {
            $icon.removeClass('fas');
            $icon.removeClass('fa-balance-scale');
            $icon.removeClass('green');

            $icon.addClass('fas');
            $icon.addClass('fa-check');
            $icon.addClass('green');
        } else {

            $icon.addClass('fas');
            $icon.addClass('fa-balance-scale');
            $icon.addClass('green');

            $icon.removeClass('fas');
            $icon.removeClass('fa-check');
            $icon.removeClass('green');
        }
    }
});