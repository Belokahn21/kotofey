import React from "react";
import ReactDOM from "react-dom";
import App from "./components/App.js";


document.addEventListener('DOMContentLoaded', function () {
	chrome.tabs.query({currentWindow: true, active: true}, function (tabs) {
		chrome.tabs.sendMessage(tabs[0].id, 'hi !', render);
	});

	function render(res) {
		ReactDOM.render(<App result={res.element}/>, document.getElementById("root"));
		localizeHtmlPage();

		document.querySelector('.form-control-button').addEventListener('click', function (event) {
			event.preventDefault();

			let url = "https://kotofey.store/rest/product/create/";
			fetch(url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				},
				body: JSON.stringify({
					element: res.element
				}),
			}).then(function (response) {
				return response.json();
			}).then(function (data) {
				document.querySelector('body').innerHTML = data;
			});
		});
	}


}, false);

function localizeHtmlPage() {
	//Localize by replacing __MSG_***__ meta tags
	var objects = document.getElementsByTagName('html');
	for (var j = 0; j < objects.length; j++) {
		var obj = objects[j];

		var valStrH = obj.innerHTML.toString();
		var valNewH = valStrH.replace(/__MSG_(\w+)__/g, function (match, v1) {
			return v1 ? chrome.i18n.getMessage(v1) : "";
		});

		if (valNewH != valStrH) {
			obj.innerHTML = valNewH;
		}
	}
}