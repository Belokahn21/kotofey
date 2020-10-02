import config from '../config';

class RemoveBasketItem {
    constructor() {
        this.elements = document.querySelectorAll('.js-remove-basket-item')

        this.initEvents();
    }

    initEvents() {
        if (!this.elements) {
            return false;
        }

        this.elements.forEach((element) => {
            element.onclick = this.remove.bind(this);
        })
    }

    remove(event) {
        event.preventDefault();
        let element = event.target;

        if (!element.classList.contains('clear-basket')) {
            element = element.parentElement;
        }

        const product_id = element.getAttribute('data-product-id');

        if (!product_id) {
            return false;
        }


        fetch(config.restDeleteBasket + product_id + '/', {
            method: 'DELETE'
        }).then(response => response.json()).then(data => {
            data = JSON.parse(data);
            if (data.status === 200) {
                element.parentNode.classList.add('is-removed');

                this.toggleText(element, 'Вернуть товар в корзину');
            }
        });
    }

    revert(event) {
        event.preventDefault();
    }

    toggleText(element, newText) {
        element.setAttribute('data-original-title', newText);
    }
}

module.exports = RemoveBasketItem;