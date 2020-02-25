chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
	price = document.querySelector('.lead').textContent.match(new RegExp(/(\d+)р./,'gi'));
	sendResponse({count: price});
});