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

		for (var i in res) {
			html += "Название: " + `${res.element.name}` + "<br>";
		}

		div.innerHTML = html;
		document.body.appendChild(div);

	}
}, false);