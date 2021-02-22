class Menu {
    constructor() {

        this.element = document.querySelector('.js-hamburger');

        this.initEvents();
    }

    initEvents() {
        this.element.onclick = this.handleClick.bind(this);
    }

    handleClick(event) {
        document.querySelector('.js-show-with-hamburger').classList.toggle('is-active');
    }
}

module.exports = Menu;