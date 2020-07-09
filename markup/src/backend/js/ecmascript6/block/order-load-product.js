import config from "../../reactjs/config";

if (document.querySelector('.load-product-info__pid')) {
	document.querySelector('.load-product-info__pid').addEventListener('change', (event) => {
		console.log("change item");
		let element = event.target;

		fetch(config.restCatalogGet + element.value + '/')
			.then(response => response.json())
			.then(json => {
				let product = JSON.parse(json);

				product.map((attribute, value) => {
					console.log(attribute);
					console.log(value);
				});
			});
	});
}
