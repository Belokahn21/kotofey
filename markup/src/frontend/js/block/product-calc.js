import config from "../config";

document.querySelectorAll('.js-product-calc').forEach((callbackElement) => {
    let formCalc = callbackElement;

    formCalc.addEventListener('submit', (event) => {
        event.preventDefault();
        console.log("форма ушла");

        fetch(config.restAddBasket, {
            method: 'PUT', // *GET, POST, PUT, DELETE, etc.
            // mode: 'no-cors', // no-cors, *cors, same-origin
            // headers: {
            //     'Content-Type': 'text/plain'
            // },
            // body: JSON.stringify({
            //     product_id: 11,
            //     count: 1,
            // })
            body: new FormData(formCalc)
        }).then(response => response.json()).then((data) => {
            const jsonResponse = JSON.parse(data);
        });

    });


    // let minusButton = null;
    // let plusButton = null;
    // let amountInput = null;
    // let summaryElement = null;
    // let summaryElement__count = null;
    // let elProductPrice = null;
    // let productPrice = null;
    // let elFullSummary = null;
    //
    // if (!formCalc) {
    //     return false;
    // }
    //
    // minusButton = formCalc.querySelector('.js-product-calc-minus');
    // plusButton = formCalc.querySelector('.js-product-calc-plus');
    // amountInput = formCalc.querySelector('.js-product-calc-amount');
    // summaryElement = formCalc.querySelector('.js-product-calc-summary');
    // summaryElement__count = summaryElement.querySelector('.count');
    // elProductPrice = formCalc.querySelector('.js-product-calc-price');
    // productPrice = elProductPrice.getAttribute('data-js-product-calc-price');
    //
    //
    // if (minusButton) {
    //     minusButton.addEventListener('click', function (event) {
    //         addAmount(-1);
    //         updateSummary();
    //         updateFullSummary();
    //     });
    // }
    //
    // if (plusButton) {
    //     plusButton.addEventListener('click', function (event) {
    //         addAmount(1);
    //         updateSummary();
    //         updateFullSummary();
    //     });
    // }
    //
    //
    // function addAmount(int) {
    //     if (parseInt(getAmount()) + parseInt(int) > 0) {
    //         setAmount(new Intl.NumberFormat('ru-RU').format(parseInt(getAmount()) + parseInt(int)));
    //     }
    // }
    //
    // function updateSummary() {
    //     summaryElement__count.innerHTML = new Intl.NumberFormat('ru-RU').format(parseInt(getAmount()) * parseInt(productPrice));
    // }
    //
    // function updateFullSummary() {
    //     let summary = 0;
    //     elFullSummary = document.querySelector('.basket-summary__count');
    //
    //     document.querySelectorAll('.js-product-calc').forEach((el) => {
    //         formCalc = el;
    //
    //         let amountInput = formCalc.querySelector('.js-product-calc-amount');
    //         let elProductPrice = formCalc.querySelector('.js-product-calc-price');
    //         let productPrice = elProductPrice.getAttribute('data-js-product-calc-price');
    //
    //         summary += parseInt(getAmount() * productPrice);
    //     });
    //
    //     if (elFullSummary) {
    //         elFullSummary.innerHTML = new Intl.NumberFormat('ru-RU').format(parseInt(summary))
    //     }
    // }
    //
    // function getAmount() {
    //     if (!amountInput) {
    //         return false;
    //     }
    //
    //     let out = 0;
    //     let matches = amountInput.value.match(/\d+/g);
    //     let matchesStr = "";
    //
    //
    //     matches.forEach((el) => {
    //         matchesStr += el;
    //     });
    //
    //     out = parseInt(matchesStr);
    //
    //     return out;
    // }
    //
    // function setAmount(value) {
    //     if (amountInput) {
    //         amountInput.value = value;
    //     }
    // }
});
