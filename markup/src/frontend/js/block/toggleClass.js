class ToggleClass {

	constructor() {
		this.addEvents();
	}

	addEvents() {
		let elements = document.querySelectorAll('.js-toggle-class');
		if (elements) {
			elements.forEach((el) => {
				el.addEventListener('click', (event) => {
					let self = event.target;
					let newClass = self.getAttribute('data-class-target');

					if (!newClass) {
						return false;
					}

					newClass = newClass.split(' ');
					console.log(newClass);

					if (Array.isArray(newClass)) {
						console.log("abra toggle cadabra");
						let i = self.querySelector('i');
						i.classList.toggle(newClass);
					}
				});
			});
		}
	}
}

new ToggleClass();