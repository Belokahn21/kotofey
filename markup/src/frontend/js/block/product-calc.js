document.querySelectorAll('.js-product-calc').forEach((callbackElement) => {
	let formCalc = callbackElement;
	let minusButton = null;
	let plusButton = null;
	let amountInput = null;
	let summaryElement = null;
	let summaryElement__count = null;
	let elProductPrice = null;
	let productPrice = null;
	let elFullSummary = null;

	if (!formCalc) {
		return false;
	}

	minusButton = formCalc.querySelector('.js-product-calc-minus');
	plusButton = formCalc.querySelector('.js-product-calc-plus');
	amountInput = formCalc.querySelector('.js-product-calc-amount');
	summaryElement = formCalc.querySelector('.js-product-calc-summary');
	summaryElement__count = summaryElement.querySelector('.count');
	elProductPrice = formCalc.querySelector('.js-product-calc-price');
	productPrice = elProductPrice.getAttribute('data-js-product-calc-price');


	minusButton.addEventListener('click', function (event) {
		addAmount(-1);
		updateSummary();
		updateFullSummary();
	});

	plusButton.addEventListener('click', function (event) {
		addAmount(1);
		updateSummary();
		updateFullSummary();
	});


	function addAmount(int) {
		if (parseInt(getAmount()) + parseInt(int) > 0) {
			setAmount(new Intl.NumberFormat('ru-RU').format(parseInt(getAmount()) + parseInt(int)));
		}
	}

	function updateSummary() {
		summaryElement__count.innerHTML = new Intl.NumberFormat('ru-RU').format(parseInt(getAmount()) * parseInt(productPrice));
	}

	function updateFullSummary() {
		let summary = 0;
		elFullSummary = document.querySelector('.basket-summary__count');

		document.querySelectorAll('.js-product-calc').forEach((el) => {
			formCalc = el;

			let amountInput = formCalc.querySelector('.js-product-calc-amount');
			let elProductPrice = formCalc.querySelector('.js-product-calc-price');
			let productPrice = elProductPrice.getAttribute('data-js-product-calc-price');

			summary += parseInt(getAmount() * productPrice);
		});

		if (elFullSummary) {
			elFullSummary.innerHTML = new Intl.NumberFormat('ru-RU').format(parseInt(summary))
		}
	}

	function getAmount() {
		let out = 0;
		let matches = amountInput.value.match(/\d+/g);
		let matchesStr = "";


		matches.forEach((el) => {
			matchesStr += el;
		});

		out = parseInt(matchesStr);

		return out;
	}

	function setAmount(value) {
		return amountInput.value = value;
	}
});
