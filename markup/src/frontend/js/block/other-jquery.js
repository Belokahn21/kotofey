// import $ from "jquery";

let Selectize = require('selectize');

$('.js-selectize').selectize({
    create: true,
    onChange: function () {
        let url = new URL(location.href);
        let params = url.searchParams

        params.set("sort", arguments[0]);

        url.search = params.toString();

        location.href = decodeURIComponent(url.toString());
    }
});

$('.modal').on('show.bs.modal', function () {
    $('.modal').modal('hide');
});

$(document).ready(function () {
    let $toast = $('.toast');
    if ($toast) {
        $toast.toast('show');
    }
});