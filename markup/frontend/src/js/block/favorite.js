import config from '../config';
import RestRequest from "../tools/RestRequest";

class Favorite {

    constructor() {
        this.initVariables();
        this.initHandleAddCompare();
        this.iniHandleDeleteCompare();
    }

    initVariables() {
        this.addCompareButtons = document.querySelectorAll('.js-add-favorite');
        this.deleteCompareButtons = document.querySelectorAll('.js-delete-favorite');
    }

    iniHandleDeleteCompare() {
        if (this.deleteCompareButtons) {
            this.deleteCompareButtons.forEach((elementForeach) => {
                elementForeach.addEventListener('click', (event) => {
                    let element = event.target;
                    let parent = element.parentElement.parentElement.parentElement;

                    if (elementForeach !== element) {
                        element = element.parentElement;
                        parent = element.parentElement.parentElement;
                    }

                    let product_id = element.getAttribute('data-product-id');

                    RestRequest.delete(config.restFavorite, product_id).then(date => {
                        parent.classList.add('hidden');
                    });
                });
            });
        }
    }

    initHandleAddCompare() {
        if (this.addCompareButtons) {
            this.addCompareButtons.forEach((elementForeach) => {
                elementForeach.addEventListener('click', (event) => {
                    let element = event.target;

                    if (elementForeach !== element) {
                        element = element.parentElement;
                    }

                    let product_id = element.getAttribute('data-product-id');

                    RestRequest.post(config.restFavorite, {
                        body: JSON.stringify({product_id: product_id})
                    }).then(date => {
                        parent.classList.add('hidden');
                    });
                });
            });
        }
    }
}

export default Favorite;