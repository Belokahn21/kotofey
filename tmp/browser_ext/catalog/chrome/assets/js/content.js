chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
	const re = new RegExp('каталог', 'gi');
	const matches = document.documentElement.innerHTML.match(re);

	const count = 0;
	if (matches != null) {
		count = matches.length;
	}

	if (count === undefined) {
		count = 0;
	}

	sendResponse({count: count});
});