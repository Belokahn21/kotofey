import config from '../config';
import Price from '../tools/Price';

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

    getNextSibling(elem, selector) {

        // Get the next sibling element
        var sibling = elem.nextElementSibling;

        // If there's no selector, return the first sibling
        if (!selector) return sibling;

        // If the sibling matches our selector, use it
        // If not, jump to the next sibling and continue the loop
        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.nextElementSibling
        }

    };


    remove(event) {
        event.preventDefault();
        let element = event.target;

        if (!element.classList.contains('clear-basket')) {
            element = element.parentElement;
        }

        if (element.classList.contains('is-removed')) {
            let form = this.getNextSibling(element, '.js-product-calc');
            return fetch(config.restAddBasket, {
                method: 'POST',
                body: new FormData(form)
            }).then(response => response.json()).then(data => {
                data = JSON.parse(data);

                if (data.status === 200) {
                    element.parentNode.classList.remove('is-removed');
                    element.classList.remove('is-removed');
                    this.toggleIcon(element, 'fa-undo');
                    this.toggleText(element, 'Удалить товар из корзины');
                    this.updateSummary();
                }

            });
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
                element.classList.add('is-removed');
                this.skipProductCalcForm(element);
                this.toggleIcon(element, 'fa-undo');
                this.toggleText(element, 'Вернуть товар в корзину');
                this.updateSummary();
            }
        });
    }

    revert(event) {
        event.preventDefault();
    }

    updateSummary() {
        let out = 0;
        let summaryElement = document.querySelector('.js-product-calc-full-summary');
        document.querySelectorAll('.js-product-calc').forEach(form => {
            if (!form.parentNode.classList.contains('is-removed')) {
                let price = 0;
                let count = 0;

                let inputAmount = form.querySelector('.js-product-calc-amount');
                if (inputAmount) {
                    count = inputAmount.value;
                }


                let priceElement = form.querySelector('.js-product-calc-price');
                if (priceElement) {
                    price = priceElement.value;
                }

                if (price > 0 && count > 0) {
                    out = out + (price * count);
                }
            }
        });

        if (summaryElement) {
            summaryElement.textContent = Price.format(out);
        }
    }

    toggleText(element, newText) {
        element.setAttribute('data-original-title', newText);
    }

    skipProductCalcForm(element) {
        let form = element.querySelector('.js-product-calc');

        if (!form) {
            return false;
        }

        form.classList.add('is-removed');
    }

    toggleIcon(element, className) {
        element.querySelector('i').classList.toggle(className);
    }
}

module.exports = RemoveBasketItem;