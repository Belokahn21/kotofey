$(document).ready(function () {
    $('.add-basket').click(function (e) {
        e.preventDefault();
        var $element = $(this);
        $.post("/ajax/tobasket/", {id: $element.data('id')}, function (data) {
            if (data.status == true) {
                $('.basket-count').html(data.htmlData);
                $element.css('background', 'green');
                $element.css('border', '1px green solid');
                $element.children('i').toggleClass('fa-shopping-cart fa-check');
            }
        }, "JSON");
    });


    $('.cart-list-item__calc i.fa-plus').click(function () {
        $.post("/ajax/plus/", {id: $(this).data('id')}, function (data) {
            $(this).parent('.cart-list-item__calc-form').siblings('.cart-list-item__calc-summ').find('span').html(data.htmldata.summ);
            $(this).siblings('.cart-list-item__calc-count').val(data.htmldata.allout);
        }, 'JSON');
    });

    $('.cart-list-item__calc i.fa-minus').click(function () {
        $.post("/ajax/minus/", {id: $(this).data('id')}, function (data) {
            $(this).parent('.cart-list-item__calc-form').siblings('.cart-list-item__calc-summ').find('span').html(data.htmldata.summ);
            $(this).siblings('.cart-list-item__calc-count').val(data.htmldata.allout);
        }, 'JSON');
    });

});