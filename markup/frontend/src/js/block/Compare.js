class Compare {
    constructor() {
        this.items = document.querySelectorAll('.js-add-compare');
        this.initEvents();
    }

    initEvents() {
        this.items.forEach(el => {
            el.onclick = this.handleAddEvent.bind(this);
        })
    }

    handleAddEvent(e) {
        e.preventDefault();

        alert('hello')
    }
}

export default Compare;