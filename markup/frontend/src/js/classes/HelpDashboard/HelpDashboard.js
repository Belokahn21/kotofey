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
        this.closePanel = document.querySelector('.js-close-help-panel');

        this.initEvents();
    }

    initEvents() {
        this.closePanel.onclick = this.handleCloseClick.bind(this);
    }

    handleCloseClick(e) {
        this.hidePanel();
    }

    clickByButton(e) {
        console.log(e.target);

        if (!this.panel.classList.contains('is-show')) this.showPanel();
        else this.hidePanel();
    }

    showPanel() {
        this.panel.classList.add('is-show');
    }

    hidePanel() {
        this.panel.classList.remove('is-show');
    }
}

export default HelpDashboard;