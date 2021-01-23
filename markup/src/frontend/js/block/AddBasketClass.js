class AddBasketClass {

    constructor(miniCart) {
        console.log(miniCart.getSummary());

        this.buttons = document.querySelectorAll('.js-add-basket').forEach(el => {
            return new AddButton(el);
        });

        console.log(this.buttons);
    }

    add(product_id, count) {

    }
}

class AddButton {
    button;

    constructor(selector) {
        if (selector instanceof Object) this.button = selector;
        else this.button = document.querySelector(selector);

        console.log(this);
        return this;
    }
}

module.exports = AddBasketClass;