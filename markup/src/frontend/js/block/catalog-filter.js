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
					fetch(location.href, {
						method: 'POST',
						body: new FormData(form)
					}).then(response => response.text()).then((data) => {
						console.log(data);

						console.log(data.querySelector('.pagination'));
					})
				}, timeout);
			});
		})
	}
}