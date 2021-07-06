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
        let element = event.target;
        let fd = new FormData();
        fd.append('link', element.value)

        RestRequest.post(config.restCatalogFill, {
            body: fd
        }).then(data => {
            if (!data instanceof Object) return false;

            Object.keys(data).map(key => {

                if (key === 'purchase') {
                    let purchase = document.querySelector('#id-purchase');
                    if (purchase) {
                        purchase.value = data[key];
                        purchase.onchange();
                    }
                } else {
                    let el = document.querySelector('#product-' + key);
                    if (el) el.value = data[key];
                }
            });

        });
    }


}

export default ProductVendorFill;