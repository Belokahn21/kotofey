import config from '../config';

class FastCart {
    constructor() {
        this.summary = document.querySelector('.fast-cart__summary');
        this.count = document.querySelector('.fast-cart__count');
    }

    setSummary(price) {
        if (this.summary) {
            fetch(config.ajaxActionGetMiniCartAmount).then(response => response.json()).then(data => {
                this.summary.textContent = data.text;
            });
        }
    }


    setCount(count) {
        if (this.count) {
            fetch(config.ajaxActionGetMiniCartCount).then(response => response.json()).then(data => {
                this.count.textContent = data.text;
            });
        }
    }


}

module.exports = FastCart;