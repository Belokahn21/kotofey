class ProductVendorFill {

    constructor() {
        this.input = document.querySelector('.catalog-fill-vendor__input');

        this.initEvents();
    }

    initEvents() {
        if (this.input) {
            this.input.addEventListener('change', this.handleInput);
        }
    }

    handleInput(element) {
        console.log(element);
    }

    sendAjax(data) {
        fetch(location.protocol + '//' + location.hostname + '/admin/catalog-fill/');
    }


}

module.exports = ProductVendorFill;