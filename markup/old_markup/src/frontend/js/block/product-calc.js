import config from "../config";
import Price from '../tools/Price';
// import promoCookie from './CookiePoromocodeClass';

let timerEx = null;

document.querySelectorAll('.js-product-calc').forEach((callbackElement) => {
        let formCalc = callbackElement;
        let discount = null;

        formCalc.addEventListener('submit', (event) => {
            event.preventDefault();

            saveInfo().then((data) => {
                const jsonResponse = JSON.parse(data);
                if (jsonResponse.status === 200) {
                    updateCountBasket(jsonResponse.count);
                    changeButtonLabel(formCalc);
                }
            });

            return false;
        });

        let plus = formCalc.querySelector('.js-product-calc-plus');
        if (plus) {
            plus.addEventListener('click', () => {
                updateAmount(formCalc, +1);
                updateSummary(formCalc);
                updateFullSummary();
                saveInfo();
            });
        }

        let minus = formCalc.querySelector('.js-product-calc-minus');
        if (minus) {
            minus.addEventListener('click', () => {
                updateAmount(formCalc, -1);
                updateSummary(formCalc);
                updateFullSummary();
                saveInfo();
            });
        }

        let summary = formCalc.querySelectorAll('.js-product-calc-plus[data-js-lazy-update=true], .js-product-calc-minus[data-js-lazy-update=true]');
        if (summary) {
            summary.forEach((element) => {
                element.addEventListener('change', () => {

                    if (timerEx) {
                        clearTimeout(timerEx);
                    }

                    timerEx = setTimeout(() => {

                        saveInfo().then((data) => {
                            const jsonResponse = JSON.parse(data);
                            if (jsonResponse.status === 200) {
                                updateCountBasket(jsonResponse.count);
                            }
                        });

                    }, 100)
                });
            });
        }

        let updateFullSummary = () => {
            let summary = 0;
            let element = document.querySelector('.js-product-calc-full-summary');

            if (element) {
                let forms = document.querySelectorAll('.js-product-calc');

                if (!forms) {
                    return false;
                }

                forms.forEach((element) => {
                    let price = element.querySelector('.js-product-calc-price');
                    let count = element.querySelector('.js-product-calc-amount');

                    if (!price || !count) {
                        return false;
                    }

                    price = parseInt(price.value);
                    count = parseInt(count.value);

                    summary += price * count;

                });

                updateDiscount();


                if (discount !== null && !isNaN(discount)) {
                    summary = summary - Math.round(summary * (discount / 100));
                }

                element.textContent = priceFormat(summary);
            }
        };

        let updateAmount = (form, count) => {
            let input = form.querySelector('.js-product-calc-amount');
            if (input && parseInt(input.value) + count > 0) {
                input.value = parseInt(input.value) + parseInt(count);
            }
        }

        let updateSummary = (form) => {
            let element = document.querySelector('.js-product-calc-summary .count');
            let inputElement = form.querySelector('.js-product-calc-amount');
            let priceElement = form.querySelector('.js-product-calc-price');
            let summary = parseInt(priceElement.value) * parseInt(inputElement.value);

            updateDiscount();

            if (!element || !inputElement || !priceElement) {
                return false;
            }

            if (discount !== null) {
                summary = Math.round(summary - (summary * (discount / 100)));
                console.log('apply discount');
            }
            element.textContent = priceFormat(summary);
        }

        let updateCountBasket = (count) => {
            let counter = document.querySelector('.basket__counter');
            if (counter) {

                counter.classList.remove('hidden');

                let element = counter.querySelector('span');
                if (element) {
                    element.textContent = count;
                }
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
            return Price.format(price);
        };

        let saveInfo = () => {
            return fetch(config.restAddBasket, {
                method: 'POST',
                body: new FormData(formCalc)
            }).then(response => response.json());
        };

        let updateDiscount = () => {
            let inputAmount = document.querySelector('.js-promocode-amount');
            if (inputAmount) {
                discount = parseInt(inputAmount.value);
            }
        };
    }
);
