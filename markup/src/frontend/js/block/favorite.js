class Favorite {
	addCompareButton = document.querySelector('.js-add-favorite');

	constructor() {
		console.log("hello");
		this.initHandleAddCompare();
	}

	initHandleAddCompare() {
		if (this.addCompareButton) {
			this.addCompareButton.addEventListener('click', () => {
				console.log("shake effect");
			});
		}
	}
}

$favorite = new Favorite();