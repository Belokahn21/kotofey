$(document).ready(function () {

    // подчёркивание меню
    var location = window.location.href;
    var cur_url = '/' + location.split('/')[3] + "/";
    $('.current-element a:not(.current-element.logo-element a)').each(function () {
        var link = $(this).attr('href');
        if (cur_url == "//") {
            cur_url = "/";
        }
        if (cur_url == link) {
            $(this).addClass('active');
        }
    });

    // добавить в закладки
    $('.item-bookmark').click(function () {
        var $element = $(this);
        $.post("/ajax/bookmark/", {id: $element.data('id')}, function (data) {
            if (data.result == 1) {
                $element.find(".far.fa-bookmark").removeClass("far").addClass('fas');
            } else {
                $element.find(".fas.fa-bookmark").removeClass("fas").addClass('far');
            }
        }, "JSON");
    });

    // переход с атрибутом href
    $('[href]:not(a)').click(function () {
        window.location.href = $(this).attr('href');
    });

    $(".ripple").on("click", function (event) {
        $(this).append("<span class='ripple-effect'>");
        $(this).find(".ripple-effect").css({
            left: event.pageX - $(this).position().left,
            top: event.pageY - $(this).position().top
        }).animate({
            opacity: 0,
        }, 1500, function () {
            $(this).remove();
        });
    });


    //одиночные изображения магнифика
    $('.image-link').magnificPopup({type: 'image'});

    $('.gallery-item').magnificPopup({
        type: 'image',
        delegate: 'a',
        gallery: {
            enabled: true
        }
    });
    $('body').on('click', '.select-point', function () {
        $(".geoData_pos").val($(this).text());
        $(".geoData_code").val($(this).data('code'));
    });
    var timer, $response = $(".response");
    $("input[name=position]").keyup(function () {
        var content = "";

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(function () {
            $.post("/ajax/geo/", $(".geoData").serialize(), function (data) {
                $response.html("");
                if (data.items.length > 0) {
                    for (var item in data.items) {
                        content = content + "<li class='select-point' data-code='" + data.items[item].CODE + "'>" + data.items[item].SOCR + ". " + data.items[item].NAME + " " + data.items[item].CODE + "</li>";
                    }

                    $response.append("<ul style='padding: 0; margin: 0; list-style: none;'>" + content + "</ul>");
                }
            }, "JSON");
        }, 1000);
    });

    setInterval(function () {
        $('.admin-panel-list__item-ts').text(Math.floor(Date.now() / 1000));
    }, 1000);
});

function copyText(elem) {
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);

    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch (e) {
        succeed = false;
    }
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }

    if (isInput) {
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        target.textContent = "";
    }
    return succeed;
}