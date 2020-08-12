class ToggleClass {

	constructor() {
		this.addEvents();
	}

	addEvents() {
		let elements = document.querySelectorAll('.js-toggle-class');
		if (elements) {
			elements.forEach((elementForeach) => {
				elementForeach.addEventListener('click', (event) => {
					let element = event.target;

					if (elementForeach !== element) {
						element = element.parentElement;
					}
				});
			});
		}
	}
}

new ToggleClass();