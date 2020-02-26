chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
	let name = document.querySelector('h2').textContent;
	let price = document.querySelector('.lead').textContent.match(new RegExp(/(\d+)р./, 'gi'));
	let article = document.getElementsByTagName('strong')[2].textContent;
	let weight = document.getElementsByTagName('strong')[3].textContent;

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
	element.price = price;
	element.article = article;
	element.weight = weight;

	sendResponse({element: element});
});