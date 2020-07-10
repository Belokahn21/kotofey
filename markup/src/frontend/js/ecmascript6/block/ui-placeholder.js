document.querySelectorAll('input[type=text], textarea').forEach((callbackElement) => {
	let placeholder = "";

	callbackElement.addEventListener('click', function (event) {
		let element = event.target;
		placeholder = element.getAttribute('placeholder');
		element.setAttribute('placeholder', '');
	});

	callbackElement.addEventListener('blur', function (event) {
		let element = event.target;
		element.setAttribute('placeholder', placeholder);
		placeholder = "";
	});

});