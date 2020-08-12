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

					let newClass = element.getAttribute('data-class-target');

					if (!newClass) {
						return false;
					}

					newClass = newClass.split(' ');
					console.log(newClass);

					if (Array.isArray(newClass)) {
						console.log("abra toggle cadabra");
						console.log(element);
						let i = element.querySelector('i');
						i.classList.map((el) => {
							i.classList.remove(i.classList[el]);
						});
						i.classList.add(newClass);
					}
				});
			});
		}
	}
}

new ToggleClass();