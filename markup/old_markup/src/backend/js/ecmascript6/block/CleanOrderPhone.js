class CleanOrderPhone {
    constructor() {
        this.el = document.querySelector('.clean-phone');
        this.replacer = [];

        if (!this.el) return false;

        this.initReplaceData();
        this.initEvents();
    }

    initEvents() {
        this.el.onchange = this.handleInput.bind(this);
        this.el.onkeyup = this.handleInput.bind(this);
    }

    initReplaceData() {
        this.replacer['+7'] = '8';
        this.replacer[')'] = '';
        this.replacer['('] = '';
        this.replacer[' '] = '';
        this.replacer['-'] = '';
    }

    handleInput(event) {
        let el = event.target;
        for (let key in this.replacer) el.value = el.value.replace(key, this.replacer[key]);
    }
}

module.exports = CleanOrderPhone;