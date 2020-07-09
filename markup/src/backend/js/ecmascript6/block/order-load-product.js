import config from "../../reactjs/config";

let timer = null;
const timeout = 2000;
const parentElements = document.querySelectorAll('.orders-items-item');


if (parentElements) {
	parentElements.forEach((parentElement) => {
		let handleElement = parentElement.querySelector('.load-product-info__pid');
		handleElement.addEventListener('keyup', handleInput);
	});
}


function handleInput(event) {
	let element = event.target;
	let parent = event.parentNode;
	let product;


	new Promise((resolve, reject) => {
		setTimeout(() => {
			product = getProduct(element.value);
		}, timeout);
	});

	if (product instanceof undefined) {
		return false;
	}

	Object.keys(product).forEach((key) => {
		let input = parent.querySelector('.load-product-info__' + key);

		if (input) {
			input.value = product[key];
		}
	});
}

async function getProduct(product_id) {
	let promise = new Promise((resolve, reject) => {
		fetch(config.restCatalogGet + product_id + '/')
			.then(response => response.json())
			.then(json => {
				return JSON.parse(json);
			});
	});

	return await promise;
}

