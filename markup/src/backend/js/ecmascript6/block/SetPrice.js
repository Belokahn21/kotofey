class SetPrice {
    constructor(element) {
        let inst = this;

        let self = document.querySelector(element);

        if (!self) {
            return false;
        }

        this.setPriceinput = self.querySelector('.set-price__input');
        this.priceInput = self.querySelector("#id-price");
        this.purchaseInput = self.querySelector("#id-purchase");


        this.initEvents();


        return inst;
    }

    initEvents() {
        if (!this.priceInput || !this.purchaseInput) {
            return false;
        }
        this.priceInput.onchange = this.onChangeSetPriceInput.bind(this);
    }

    onChangeSetPriceInput() {

    }
}

module.exports = SetPrice;