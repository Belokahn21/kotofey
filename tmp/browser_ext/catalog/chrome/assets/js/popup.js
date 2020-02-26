document.addEventListener('DOMContentLoaded', function () {
	'use strict';
	import React from 'react';

	const reactElement = React.createElement;

	class ItemForm extends React.Component {
		render() {
			return (
				1
			);
		}
	}

	chrome.tabs.query({currentWindow: true, active: true}, function (tabs) {
		chrome.tabs.sendMessage(tabs[0].id, 'hi !', render);
	});

	function render(res) {
		//use react js
		ReactDOM.render(<ItemForm/>, document.querySelector('#like_button_container'));
	}


}, false);