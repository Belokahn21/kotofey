$(document).ready(function () {

    $('.phone_mask').text(function (i, text) {
        return text.replace(/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 ($2) $3 $4-$5');
    });

    var placeholder = "";
    $("input[type=text]").click(function () {

        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', "");

    }).blur(function () {

        $(this).attr('placeholder', placeholder);
        placeholder = "";

    });

    // пункты описания в детальном просмотре товара
    $(".harmon-title").click(function () {
        var $this = $(this);
        $this.find('i').toggleClass("fa-chevron-up fa-chevron-down");
        $this.siblings(".harmon-content").slideToggle("slow");
    });

    var providers = $('.list-providers').owlCarousel({
        loop: true,
        items: 1,
        slideBy: 1,
        scrollPerPage: true,
        autoHeight: true,
        autoWeight: true
        // dots: true
    });

    var news = $('.list-news').owlCarousel({
        loop: true,
        items: 1,
        slideBy: 1,
        scrollPerPage: true,
        autoHeight: true,
        autoWeight: true
        // dots: true
    });


    var owl = $('.owl-main').owlCarousel({
        margin: 10,
        loop: true,
        items: 1,
        slideBy: 1,
        scrollPerPage: true,
        autoHeight: true,
        autoWeight: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            960: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    var owlDetail = $('.owl-detail').owlCarousel({
        margin: 10,
        loop: true,
        items: 3,
        autoHeight: true,
        autoWeight: true,
    });

    //Firefox:
    owl.on('DOMMouseScroll', '.owl-stage', function (e) {
        if (e.originalEvent.detail > 0) {
            $(this).trigger('next.owl');
        } else {
            $(this).trigger('prev.owl');
        }
        e.preventDefault();
    });
    //Chrome, IE
    owl.on('mousewheel', '.owl-stage', function (e) {
        if (e.originalEvent.wheelDelta > 0) {
            $(this).trigger('next.owl');
        } else {
            $(this).trigger('prev.owl');
        }
        e.preventDefault();
    });


    // удалить из закладок в личном профиле
    $(".owl-carousel div i").click(function () {
        var $this = $(this);
        $.post("/ajax/removebookmark/", {id: $this.data('id')}, function (data) {
            if (data.result == 2) {

                $this.parent("div").remove();

                owl.trigger('refresh.owl.carousel');

            }
        }, 'JSON');
    });

    showTab(0);
    $(".select-type-order div").click(function () {

        var $this = $(this);
        $this.siblings('div').removeClass("active");
        $this.addClass("active");

        showTab($this.index())
    });

    function showTab(index) {

        $(".custom-order-elems").hide().eq(index).show();
    }

    $('.show-drop').click(function () {
        $('.drop-all-cats').toggleClass("show hide");
    });


    $('.type-order-list__item').click(function () {
        var $this = $(this);
        var cookie_value = $this.data('cookie');

        $.cookie('order', cookie_value);

        $('.type-order-list__item').each(function () {
            $(this).removeClass('active')
        });
        $this.addClass('active');

        $('.checkout-form').hide().eq($this.index()).show();
    });

    $('.show-catalog-filter').click(function (e) {
        $('.filter').toggle();
    });

    $("#filter-form-id").catalogFilter();
});


(function ($) {
    var methods = {
        init: function (options) {
            console.log("plugin catalog filter runed");
        },
        show: function () {
            // ПОДХОД
        },
        hide: function () {
            // ПРАВИЛЬНЫЙ
        },
        update: function (content) {
            // !!!
        }
    };
    $.fn.catalogFilter = function (method) {
        var $this = this;

        this.find("input, select").each(function () {

            $(this).change(function () {

                $.ajax({
                    'url': location.href + '?' + $this.serialize(),
                    'method': 'get',
                    beforeSend: function () {
                        $('.pagination-wrap').html("");


                        $('.catalog-list').html($('<img>', {
                            src: '/web/upload/images/loading.gif',
                            css: {
                                'width': ' 300px',
                                'height': ' 300px',
                                'align-self': 'center',
                                'align-content': 'center'
                            }
                        }));
                    },
                    success: function (data) {

                        setTimeout(function () {

                            var $page = $(data);

                            $('.catalog-list').html("");

                            $page.find('.catalog-list').find('li').each(function () {
                                $('.catalog-list').append($(this));
                            });
                            $('.pagination-wrap').html($page.find('.pagination'));

                        }, 2500);

                    }
                });

                // $.post("/ajax/filter/", $this.serialize(), function (data) {
                //     console.log(data);
                // }, "JSON");
            });
        });

        // логика вызова метода
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод с именем ' + method + ' не существует для catalog filter');
        }
    };
})(jQuery);