import datepicker from 'air-datepicker';

document.querySelector('.set-price__action').addEventListener('click', function () {
    let inputPurchase = document.querySelector('#id-purchase');
    let inputPrice = document.querySelector('#id-price');
    let inputDiscount = document.querySelector('.set-price__input');

    let purchase = parseInt(inputPurchase.value);
    let percent = null;
    if (parseInt(inputDiscount.value) > 0) {
        percent = inputDiscount.value;
    }
    let coef = percent / 100;
    inputPrice.value = purchase + Math.ceil(purchase * coef);
});
document.querySelector('.set-price__input').addEventListener('change', function () {
    let input = this;

    if (input) {
        fetch('/ajax/save-cookie-discount/', {
            method: 'post',
            body: JSON.stringify({
                amount: input.value
            })
        });
    }
});