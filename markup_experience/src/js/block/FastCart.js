import config from '../config';

class FastCart {
    constructor() {
        this.element = document.querySelector('.fast-cart');
        this.summary = document.querySelector('.fast-cart__summary');
        this.count = document.querySelector('.fast-cart__count');
    }

    setSummary(price) {
        if (this.summary) {
            this.showWidget();
            fetch(config.ajaxActionGetMiniCartAmount).then(response => response.json()).then(data => {
                this.summary.textContent = data.text;
            });
        }
    }


    setCount(count) {
        if (this.count) {
            this.showWidget();
            fetch(config.ajaxActionGetMiniCartCount).then(response => response.json()).then(data => {
                this.count.textContent = data.text;
            });
        }
    }

    showWidget() {
        if (!this.element.classList.contains('active')) this.element.classList.add('active');
    }

    hideWidget() {
        if (this.element.classList.contains('active')) this.element.classList.remove('active');
    }


}

export default FastCart;