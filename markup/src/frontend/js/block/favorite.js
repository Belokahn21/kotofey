class Favorite {

	constructor() {
		this.initVariables();
		this.initHandleAddCompare();
	}

	initVariables() {
		this.addCompareButton = document.querySelector('.js-add-favorite');
	}

	initHandleAddCompare() {
		if (this.addCompareButton) {
			this.addCompareButton.addEventListener('click', () => {
				console.log("shake effect");
			});
		}
	}
}

let favorite = new Favorite();