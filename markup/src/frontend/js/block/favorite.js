import config from '../config';

class Favorite {

    constructor() {
        this.initVariables();
        this.initHandleAddCompare();
    }

    initVariables() {
        this.addCompareButtons = document.querySelectorAll('.js-add-favorite');
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
                    fetch(config.restAddFavorite, {
                        method: 'POST',
                        body: JSON.stringify({
                            product_id: product_id
                        })
                    }).then(response => response.json()).then(date => {
                        console.log(date);
                    });
                });
            });
        }
    }
}

let favorite = new Favorite();