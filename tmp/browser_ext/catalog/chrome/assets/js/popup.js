document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('button').addEventListener('click', onClick, false);

    function onClick() {
        chrome.tabs.query({currentWindow: true, active: true}, function (tabs) {
            chrome.tabs.sendMessage(tabs[0].id, 'hi !', setCount);
        });
    }

    function setCount(res) {
        const div = document.createElement('div');
        let html = "";

        let form = document.createElement('form');
        form.setAttribute('class','milenium-form');

        let nameInput = document.createElement('input');
        nameInput.setAttribute('name', 'name');
        nameInput.setAttribute('value', res.element.name);


		let priceInput = document.createElement('input');
		priceInput.setAttribute('name', 'price');
		priceInput.setAttribute('value', res.element.price);


		let articleInput = document.createElement('input');
		articleInput.setAttribute('name', 'price');
		articleInput.setAttribute('value', res.element.article);


		let weightInput = document.createElement('input');
		weightInput.setAttribute('name', 'price');
		weightInput.setAttribute('value', res.element.weight);

        form.appendChild(nameInput);
        form.appendChild(priceInput);
        form.appendChild(articleInput);
        form.appendChild(weightInput);

        document.body.appendChild(form);

    }
}, false);