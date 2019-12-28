$(document).ready(function () {

    $('.billing__indicator.is-main').click(function () {
        var $this = $(this);
        var billing_id = $this.data('billing-id');

        var $active_i_element = $('<i></i>', {
            'class': 'fas fa-check-circle'
        });

        var $not_active_i_element = $('<i></i>', {
            'class': 'far fa-check-circle',
            'data-placement': 'right',
            'data-toggle': 'tooltip',
            'title': 'Адрес назначен как основной',
        });

        if (billing_id) {
            $.ajax({
                url: '/ajax/billing/' + billing_id + '/',
                method: 'POST',
                success: function (data) {
                    console.log(data);

                    var json_data = JSON.parse(data);

                    if (json_data.code === 'success') {
                        $this.find('.fas.fa-check-circle').remove();
                        $this.find('.far.fa-check-circle').remove();

                        $this.html($active_i_element);
                        $this.removeClass('is-main');
                    }
                }

            });
        }
    });

});

