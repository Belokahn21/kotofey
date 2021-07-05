import RestRequest from "../../../../frontend/src/js/tools/RestRequest";
import config from "../../../../backend/src/js/react/config";

class ProductVendorFill {

    constructor() {
        this.input = document.querySelector('.catalog-fill-vendor__input');

        this.initEvents();
    }

    initEvents() {
        if (!this.input) return false;


        this.input.onchange = this.handleInput.bind(this);
    }

    handleInput(event) {
        console.log(event);
        let element = event.target;

        RestRequest.one(config.restCatalogFill, escape(btoa(element.value)));
    }


}

export default ProductVendorFill;