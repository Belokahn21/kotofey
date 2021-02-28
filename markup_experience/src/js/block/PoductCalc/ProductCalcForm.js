import Price from "../../tools/Price";
import config from "../../config";

class ProductCalcForm {

    constructor(element, miniCart) {
        if (element instanceof Object) this.form = element;
        this.plusElement = this.form.querySelector('.js-product-calc-plus');
        this.minusElement = this.form.querySelector('.js-product-calc-minus');
        this.amountElement = this.form.querySelector('.js-product-calc-amount');
        this.priceElement = this.form.querySelector('.js-product-calc-price');
        this.count = 0;
        this.summaryPrice = 0;
        this.discount = 0;
        this.miniCart = miniCart;
        this.iniEvents();
    }

    iniEvents() {
        if (this.form) this.form.onsubmit = this.submitForm.bind(this);
        if (this.plusElement) this.plusElement.onclick = this.plus.bind(this);
        if (this.minusElement) this.minusElement.onclick = this.minus.bind(this);
        if (this.amountElement) this.amountElement.onchange = this.submitForm.bind(this);
    }


    plus(e) {
        this.updateAmount(1);
        this.updateSummary();
        this.updateFullSummary();
        this.saveInfo();

        this.miniCart.setSummary();
        this.miniCart.setCount();
    }

    minus(e) {
        this.updateAmount(-1);
        this.updateSummary();
        this.updateFullSummary();
        this.saveInfo();

        this.miniCart.setSummary();
        this.miniCart.setCount();
    }

    submitForm(e) {
        e.preventDefault();

        this.saveInfo().then((data) => {
            const jsonResponse = JSON.parse(data);
            if (jsonResponse.status === 200) {
                this.updateCountBasket(jsonResponse.count);
                this.changeButtonLabel();
                this.updateFullSummary();

                this.miniCart.setSummary(this.summaryPrice);
                this.miniCart.setCount(this.count);
            }
        });

        return false;
    }


    updateFullSummary() {
        let element = document.querySelector('.js-product-calc-full-summary');
        let forms = document.querySelectorAll('.js-product-calc');

        if (!forms) return false;

        forms.forEach((element) => {
            let price = element.querySelector('.js-product-calc-price');
            let count = element.querySelector('.js-product-calc-amount');

            if (!price || !count) return false;


            price = parseInt(price.value);
            count = parseInt(count.value);
        });

        this.updateDiscount();

        if (this.discount !== null && !isNaN(this.discount)) this.summaryPrice = this.summaryPrice - Math.round(this.summaryPrice * (this.discount / 100));

        if (element) element.textContent = priceFormat(this.summaryPrice);

    };

    updateAmount(count) {
        let input = this.amountElement;
        if (input && parseInt(input.value) + count > 0) {
            input.value = parseInt(input.value) + parseInt(count);
        }
    }

    updateSummary() {
        let element = document.querySelector('.js-product-calc-summary .count');
        let inputElement = this.amountElement;
        let priceElement = this.priceElement;
        let summary = parseInt(priceElement.value) * parseInt(inputElement.value);

        this.updateDiscount();

        if (!element || !inputElement || !priceElement) return false;


        if (this.discount !== null) {
            summary = Math.round(summary - (summary * (this.discount / 100)));
            console.log('apply this.discount');
        }
        element.textContent = this.priceFormat(summary);
    }

    updateCountBasket(count) {
        let counter = document.querySelector('.basket__counter');
        if (counter) {
            counter.classList.remove('hidden');
            let element = counter.querySelector('span');
            if (element) element.textContent = count;
        }
    }

    changeButtonLabel() {
        let button = this.form.querySelector('.js-add-basket');
        if (button) {
            this.toggleText(button, 'Добавлено');
            this.toggleIcon(button);
        }
    };

    toggleIcon(element) {
        let image = element.querySelector('.add-basket__icon');
        image.setAttribute('src', '/upload/images/arrow-success.png');
    };

    toggleText(element, text) {
        element.querySelector('.add-basket__label').textContent = text;
    };

    priceFormat(price) {
        return Price.format(price);
    };

    saveInfo() {
        return fetch(config.restAddBasket, {
            method: 'POST',
            body: new FormData(this.form)
        }).then(response => response.json());
    };

    updateDiscount() {
        let inputAmount = document.querySelector('.js-promocode-amount');
        if (inputAmount) this.discount = parseInt(inputAmount.value);
    };
}

export default ProductCalcForm;