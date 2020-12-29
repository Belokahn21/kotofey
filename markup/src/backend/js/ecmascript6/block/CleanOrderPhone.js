class CleanOrderPhone {
    constructor() {
        this.el = document.querySelector('.clean-phone');

        if (!this.el) return false;

        this.initEvents();

    }

    initEvents() {
        this.el.onchange = this.handleInput.bind(this);
        this.el.onkeyup = this.handleInput.bind(this);

    }

    handleInput(event) {
        let el = event.target;

        el.value = el.value.replace('+7', '8');
        el.value = el.value.replace(')', '');
        el.value = el.value.replace('(', '');
        el.value = el.value.replace(' ', '');
        el.value = el.value.replace('-', '');
    }
}

module.exports = CleanOrderPhone;