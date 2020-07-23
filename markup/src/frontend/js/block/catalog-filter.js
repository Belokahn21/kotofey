import config from '../config';

let form = document.querySelector('#filter-form-id');
let timerex = null;
const timeout = 200;
if (form) {
	form.addEventListener('submit', () => {
	});


	let inputs = form.querySelectorAll('input, select');

	if (inputs) {
		inputs.forEach((element) => {
			element.addEventListener('change', () => {
				console.log('element changed');

				if (timerex) {
					clearTimeout(timerex);
				}

				timerex = setTimeout(() => {
					fetch(config.restGetCatalog, {
						method: 'POST',
						body: new FormData(form)
					}).then(response => response.json()).then((data) => {
						const products = JSON.parse(data);

						if (products) {
							console.log(products);
						}
					})
				}, timeout);
			});
		})
	}
}