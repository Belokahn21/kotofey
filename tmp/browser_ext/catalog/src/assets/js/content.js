chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
	let name = document.querySelector('h2').textContent;
	var price = document.querySelector('.lead').textContent.match(new RegExp(/(\d+)р./, 'gi'));
	price = price.toString().match(new RegExp(/(\d+)/, 'gi'));
	let article = document.getElementsByTagName('strong')[2].textContent;
	let weight = document.getElementsByTagName('strong')[3].textContent;
	let description = document.querySelector('.desc').textContent;

	weight = weight.split(" ");

	switch (weight[1]) {
		case "гр.":
			weight = weight[0] / 1000;
			break;
		default:
			weight = weight[0];
			break;
	}

	const element = {};

	element.name = name;
	element.base_price = price[0];
	element.purchase = element.base_price;
	element.price = Math.ceil(element.purchase + element.purchase * 0.30);
	element.article = article;
	element.weight = weight;
	element.description = description;
	element.count = 0;

	sendResponse({element: element});
});
