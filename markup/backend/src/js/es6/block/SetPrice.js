import config from '../../reactjs/config';

class SetPrice {
    constructor(element) {
        let inst = this;

        this.timerEx;
        this.timeoutSave = 200;

        let self = document.querySelector(element);

        if (!self) {
            return false;
        }

        this.applyDiscount = self.querySelector('.set-price__action');
        this.discountInput = self.querySelector('.set-price__input');
        this.priceInput = document.querySelector("#id-price");
        this.purchaseInput = document.querySelector("#id-purchase");


        this.initEvents();


        return inst;
    }

    initEvents() {
        if (!this.priceInput || !this.purchaseInput) {
            return false;
        }

        this.purchaseInput.onchange = this.handlePurchase.bind(this);
        this.purchaseInput.onkeyup = this.handlePurchase.bind(this);

        this.discountInput.onchange = this.handleDiscount.bind(this);
        this.discountInput.onkeyup = this.handleDiscount.bind(this);

        this.applyDiscount.onclick = this.handleApply.bind(this);
    }

    handlePurchase() {
        this.priceInput.value = parseInt(this.purchaseInput.value) + parseInt(Math.round(this.purchaseInput.value * (this.discountInput.value / 100)));
    }

    handleDiscount() {

        if (!this.discountInput.value) {
            return false;
        }

        this.handleApply();

        if (!this.discountInput.value || !this.purchaseInput.value) {
            return false;
        }

        this.priceInput.value = parseInt(this.purchaseInput.value) + parseInt(Math.round(this.purchaseInput.value * (this.discountInput.value / 100)));
    }

    handleApply(event) {

        if (this.timerEx) {
            clearTimeout(this.timerEx)
        }

        this.timerEx = setTimeout(() => {
            fetch(config.ajaxSaveProductMark + this.discountInput.value + '/').then(response => response.json()).then(data => {
                console.log(data);
            });
        }, this.timeoutSave);
    }
}


export default SetPrice;