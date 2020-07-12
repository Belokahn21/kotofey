let oldSrcValue = "";
import config from '../config';

document.querySelectorAll('.js-add-basket').forEach((forEachElement) => {

    forEachElement.addEventListener('click', (event) => {
        let element = event.target;
        let product_id;
        let count;

        if (forEachElement !== element) {
            element = element.parentElement;
        }

        product_id = element.getAttribute('data-product-id');
        count = element.getAttribute('data-product-count');

        fetch(config.restAddBasket, {
            method: 'PUT', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            // credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            // redirect: 'follow', // manual, *follow, error
            // referrerPolicy: 'no-referrer', // no-referrer, *client
            body: JSON.stringify({
                product_id: product_id,
                count: count,
            }) // body data type must match "Content-Type" header
        }).then(response => response.json()).then((data) => {
            console.log("ascasc");
            toggleIcon(element);
            toggleText(element, 'Добавлено')
        });
    });

});

function toggleIcon(element) {
    let image = element.querySelector('.add-basket__icon');

    oldSrcValue = image.getAttribute('src');
    image.setAttribute('src', './assets/images/arrow-success.png');
}

function toggleText(element, text) {
    element.querySelector('.add-basket__label').textContent = text;
}
