import config from '../config';

class Favorite {

	constructor() {
		this.initVariables();
		this.initHandleAddCompare();
	}

	initVariables() {
		this.addCompareButton = document.querySelector('.js-add-favorite');
	}

	initHandleAddCompare() {
		if (this.addCompareButton) {
			this.addCompareButton.addEventListener('click', (event) => {
				let element = event.target;
				let product_id = element.getAttribute('data-product-id');
				fetch(config.restAddFavorite, {
					method: 'POST',
					body: {
						product_id: product_id
					}
				}).then(response => response.json()).then(date => {
					console.log(date);
				});
			});
		}
	}
}

let favorite = new Favorite();