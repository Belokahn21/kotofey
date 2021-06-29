import * as Cookies from "es-cookie";

class SiteMessage {
    constructor() {
        this.COOKIE_KEY_CODE = 'show_site_message';

        this.element = document.querySelector('.site-message');
        if (!this.element) return false;

        this.button_action = this.element.querySelector('.js-handle-message');
        if (!this.button_action) return false;


        this.bindAction();
    }

    bindAction() {
        this.button_action.onclick = this.handleClick.bind(this);
    }

    handleClick(event) {
        this.save('N');
        this.remove();
    }

    save(value) {
        Cookies.set(this.COOKIE_KEY_CODE, value);
    }

    remove() {
        this.element.remove();
    }
}

export default SiteMessage;