class Catalog {
    constructor() {
        this.arrow = document.querySelectorAll('.filter-catalog__arrow');
        this.container = document.querySelector('.filter-catalog-container');
        this.element = null;

        this.initEvents();
    }

    initEvents() {
        this.arrow.forEach((foreachElement) => {
            foreachElement.addEventListener('click', (event) => {

                this.element = event.target;

                if (foreachElement !== this.element) {
                    this.element = this.element.parentElement;
                }

                this.toggle();
            });
        });
    }


    toggle() {
        if (this.element.classList.contains('is-active') && this.container.classList.contains('is-active')) {
            this.hide();
        } else {
            this.show();
        }
    }


    show() {
        if (this.container !== null) {
            this.container.classList.add('is-active');
        }
        if (this.element !== null) {
            this.element.classList.add('is-active');
        }
    }

    hide() {
        if (this.container !== null) {
            this.container.classList.remove('is-active');
        }

        if (this.element !== null) {
            this.element.classList.remove('is-active');
        }
    }


}

module.exports = Catalog;