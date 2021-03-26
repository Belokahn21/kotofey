//todo не работает, только начато https://codepen.io/iiil/pen/Lkazu
class SmoothChangeNumber {
    constructor(selector, options = false) {
        this.items = [...document.querySelectorAll(selector)];
        this.applyEvents();
    }

    applyEvents() {
        this.items.map(el => {
            el.oninput = this.handleChange.bind(this);
        });
    }

    handleChange() {
        alert();
    }
}

export default SmoothChangeNumber;