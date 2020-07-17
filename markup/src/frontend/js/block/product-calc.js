import config from "../config";

let timerEx = null;

document.querySelectorAll('.js-product-calc').forEach((callbackElement) => {
	let formCalc = callbackElement;

	formCalc.addEventListener('submit', (event) => {
		event.preventDefault();

		saveInfo().then((data) => {
			const jsonResponse = JSON.parse(data);
			if (jsonResponse.status === 200) {
				// обновить кол-во позиций в иконке корзины
				updateCountBasket(jsonResponse.count);
				changeButtonLabel(formCalc);
			}
		});
	});

	let plus = formCalc.querySelector('.js-product-calc-plus');
	if (plus) {
		plus.addEventListener('click', () => {
			updateAmount(formCalc, +1);
			updateSummary(formCalc);
		});
	}
	let minus = formCalc.querySelector('.js-product-calc-minus');
	if (minus) {
		minus.addEventListener('click', () => {
			updateAmount(formCalc, -1);
			updateSummary(formCalc);
		});
	}

	let updateAmount = (form, count) => {
		let input = form.querySelector('.js-product-calc-amount');
		if (input && parseInt(input.value) + count > 0) {
			input.value = parseInt(input.value) + parseInt(count);
		}
	}

	let updateSummary = (form) => {
		let element = document.querySelector('.js-product-calc-summary').querySelector('.count');
		let inputElement = form.querySelector('.js-product-calc-amount');
		let priceElement = form.querySelector('.js-product-calc-price');
		const price = priceElement.getAttribute('data-js-product-calc-price');

		if (!element || !inputElement || !priceElement) {
			return false;
		}

		element.textContent = priceFormat(parseInt(price) * parseInt(inputElement.value));
	}

	let updateCountBasket = (count) => {
		let element = document.querySelector('.basket__counter').querySelector('span');
		if (element) {
			element.textContent = count;
		}
	}

	let changeButtonLabel = (form) => {
		let button = form.querySelector('.js-add-basket');
		if (button) {
			toggleText(button, 'Добавлено');
			toggleIcon(button);
		}
	};


	let toggleIcon = (element) => {
		let image = element.querySelector('.add-basket__icon');
		image.setAttribute('src', '/upload/images/arrow-success.png');
	};

	let toggleText = (element, text) => {
		element.querySelector('.add-basket__label').textContent = text;
	};

	let priceFormat = (price) => {
		return new Intl.NumberFormat('ru-RU').format(price);
	};

	let saveInfo = () => {
		return fetch(config.restAddBasket, {
			method: 'POST',
			body: new FormData(formCalc)
		}).then(response => response.json());
	};
});
