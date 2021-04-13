import HelpDashboardButton from "./HelpDashboardButton";

class HelpDashboard {
    constructor() {
        const buttonClass = new HelpDashboardButton('.js-show-panel', {
            event: {
                onClick: this.clickByButton.bind(this)
            }
        });
        this.button = buttonClass.getButton();
        this.panel = document.querySelector('.js-help-panel');
    }

    clickByButton(e) {
        console.log("demo event");
    }
}

export default HelpDashboard;