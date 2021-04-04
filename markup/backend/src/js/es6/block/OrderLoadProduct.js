import config from "../../reactjs/config";

let timer = null;
const timeout = 2000;
const parentElements = document.querySelectorAll('.orders-items-item');


if (parentElements) {
    parentElements.forEach((parentElement) => {
        let handleElement = parentElement.querySelector('.load-product-info__pid');
        if (handleElement) {
            // handleElement.onkeyup = handleInput.bind(this);
            // handleElement.onchange = handleInput.bind(this);
            handleElement.addEventListener('change', handleInput);
            handleElement.addEventListener('keyup', handleInput);
        }
    });
}

function handleInput(event) {
    let element = event.target;
    let parent = element.closest('.orders-items-item');
    let product_id = element.value;

    getProduct(product_id).then((data) => {
        let product = data;

        for (const [key, value] of Object.entries(product)) {

            if (key === 'count') continue;

            let input = parent.querySelector('.load-product-info__' + key);
            if (input) input.value = value;
        }
    });
}

function getProduct(product_id) {
    return fetch(config.restCatalog + product_id + '/').then(response => response.json());
}