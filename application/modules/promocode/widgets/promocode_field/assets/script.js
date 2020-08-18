class handlePromocodeInput {

	constructor() {
		this.inputPromo = document.querySelector('.js-validate-promocode');
		this.codeContainerElement = document.querySelector('.checkout-form-promocode');
		this.codeElement = document.querySelector('.checkout-form-promocode__code');
		this.discountElement = document.querySelector('.checkout-form-promocode__discount');
		this.elementFullPrice = document.querySelector('.js-product-calc-full-summary');

		this.addEvent();
	}

	addEvent() {
		this.inputPromo.addEventListener('change', (event) => {
			this.checkPromocode(event.target.value);
		});
	}

	checkPromocode(value) {
		const url = location.protocol + '//' + location.hostname;
		fetch(url + '/promocode/rest/get/' + value + '/').then(response => response.json()).then(data => {

			if (data == null) {
				return false;
			}

			this.showPromocodeInfo(data.code, '-' + data.discount + '%');
			this.updateCheckoutPrice(data.discount);
			this.saveSessionPromocode(data.code);
		});
	}

	showPromocodeInfo(code, discount) {
		if (!this.codeElement && !this.discountElement) {
			return false;
		}

		this.codeContainerElement.classList.add('active');

		this.codeElement.textContent = code;
		this.discountElement.textContent = discount;
	}

	updateCheckoutPrice(discount) {

		if (!this.elementFullPrice) {
			return false;
		}

		let price = this.elementFullPrice.textContent;
		price = price.replace(/ /g, '');
		price = parseInt(price);

		discount = parseInt(discount);
		discount = discount / 100;

		let final = price - parseInt(Math.floor(price * discount));
		let intervalId = null;


		intervalId = setInterval(() => {

			if (price === final) {
				clearInterval(intervalId);
			}

			this.elementFullPrice.textContent = this.price(--price);

		}, 5);
	}

	saveSessionPromocode(code) {

	}

	price(value) {
		let formater = new Intl.NumberFormat('ru-RU', {});
		return formater.format(value);
	}
}


new handlePromocodeInput();