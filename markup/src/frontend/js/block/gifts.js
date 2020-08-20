class Gifts {
	constructor() {
		this.lastWidth = 0;
		this.button = document.querySelector('.js-run-road-gift');
		this.images = document.querySelectorAll('.gifts-road__image');
		this.addEvents();
		this.stayImages();
	}

	addEvents() {
		if (!this.button) {
			return false;
		}

		this.button.addEventListener('click', () => {
			setInterval(() => {
				this.stayImages();
			}, 1000);
		});
		// this.button.addEventListener('click', this.runAnimation());

	}

	stayImages() {
		this.images.forEach((image) => {
			let width = image.offsetWidth;
			this.lastWidth += parseInt(width);
			image.style.left = this.lastWidth + 'px';
		});
	}
}

new Gifts();