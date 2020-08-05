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
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: product_id,
                count: count,
            })
        }).then(response => response.json()).then((data) => {
            const jsonResponse = JSON.parse(data);
            toggleIcon(element);
            toggleText(element, 'Добавлено');
            updateCounter(jsonResponse.count)
        });
    });

});

function updateCounter(i) {
    let element = document.querySelector('.basket__counter').querySelector('span');
    if (element) {
        element.textContent = i;
    }
}

function toggleIcon(element) {
    let image = element.querySelector('.add-basket__icon');

    oldSrcValue = image.getAttribute('src');
    image.setAttribute('src', '/upload/images/arrow-success.png');
}

function toggleText(element, text) {
    element.querySelector('.add-basket__label').textContent = text;
}
