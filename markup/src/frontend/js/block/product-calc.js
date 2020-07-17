import config from "../config";

document.querySelectorAll('.js-product-calc').forEach((callbackElement) => {
	let formCalc = callbackElement;

	formCalc.addEventListener('submit', (event) => {
		event.preventDefault();

		fetch(config.restAddBasket, {
			method: 'POST',
			body: new FormData(formCalc)
		}).then(response => response.json()).then((data) => {
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
		});
	}
	let minus = formCalc.querySelector('.js-product-calc-minus');
	if (minus) {
		minus.addEventListener('click', () => {
			updateAmount(formCalc, -1);
		});
	}

	let updateAmount = (form, count) => {
		let input = form.querySelector('.js-product-calc-amount');
		if (input && parseInt(input.value) + count > 0) {
			input.value = parseInt(input.value) + parseInt(count);
		}
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
		image.setAttribute('src', './assets/images/arrow-success.png');
		// image.setAttribute('src', '/upload/images/arrow-success.png');
	}

	function toggleText(element, text) {
		element.querySelector('.add-basket__label').textContent = text;
	}
});
