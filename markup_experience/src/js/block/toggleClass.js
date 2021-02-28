class ToggleClass {

	constructor() {
		this.addEvents();
	}

	addEvents() {
		let elements = document.querySelectorAll('.js-toggle-class');
		if (elements) {
			elements.forEach((elementForeach) => {
				let srcClass = null;
				let targetClass = null;
				elementForeach.addEventListener('click', (event) => {
					let element = event.target;

					if (elementForeach !== element) {
						element = element.parentElement;
					}
					let tmp = null;
					let i = element.querySelector('i');

					if (targetClass == null) {
						targetClass = element.getAttribute('data-class-target');
					}
					srcClass = i.getAttribute('class');

					i.setAttribute('class', targetClass);

					tmp = srcClass;
					srcClass = targetClass;
					targetClass = tmp;

				});
			});
		}
	}
}

new ToggleClass();