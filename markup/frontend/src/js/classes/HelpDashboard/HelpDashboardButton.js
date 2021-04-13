class HelpDashboardButton {
    constructor(selector, settings) {
        this.settings = settings;
        this.button = document.querySelector(selector);

        this.initEvent();
    }

    getButton() {
        return this.button;
    }

    initEvent() {
        this.button.onclick = this.handleClick.bind(this);
    }

    handleClick(event) {
        event.preventDefault();

        Object.keys(this.settings.event).map((e, i) => {

            document.addEventListener(e, this.settings.event[e]);
            let event = new Event(e, {bubbles: true}); // (2)
            this.button.dispatchEvent(event);
        })

        // console.log(this.settings.event);
    }
}


export default HelpDashboardButton;