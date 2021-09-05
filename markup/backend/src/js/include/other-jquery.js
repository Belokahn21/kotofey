import RestRequest from "../../../../frontend/src/js/tools/RestRequest";
import config from "../react/config";

$('.js-load-composition').change(function (e) {
    let $this = $(this);

    RestRequest.all(config.restProductComposition + '?CompositionProductSearchForm[product_id]=' + $this.val()).then(data => {
        data.map(el => {
            let j1 = $(`.js-row-composition[data-composit-id="${el.composition_id}"]`);
            let j2 = $(`.js-row-metrik[data-composit-id="${el.composition_id}"]`);
            let j3 = $(`.js-row-composition-id[data-composit-id="${el.composition_id}"]`);

            j1.val(el.value);
            j2.val(el.metric_id);
            j3.val(el.composition_id);
        });
    });
});

$('.js-reset-composition').click(function (e) {
    e.preventDefault();
    $('#nav-composition input:not(.js-row-product-id)').each(function (index, el) {
        $(el).val('');
    });
    $('#nav-composition select').each(function (index, el) {
        $(el).prop('selectedIndex', 0)
    });
});