import {forEach} from "react-bootstrap/ElementChildren";

class CopyFormElement {

    constructor() {
        this.button_add_new = document.querySelector('.js-add-new-line-item');
        this.area_new_insert = document.querySelector('.js-add-new-line-area');
        this.target_key = 0;
        this.counter = 0;

        this.initEvents()
    }

    initEvents() {
        if (this.button_add_new) this.button_add_new.onclick = this.handleClick.bind(this);
    }

    handleClick(event) {
        let element = event.target;
        this.target_key = element.getAttribute('data-target');
        this.counter = parseInt(element.getAttribute('data-counter'));

        if (this.target_key.length === 0) return false;

        let targetCopyElement = document.querySelector(this.target_key).cloneNode(true);

        if (!targetCopyElement) return false;

        targetCopyElement.removeAttribute('style');

        this.counter++;

        targetCopyElement.querySelectorAll('[name]').forEach(el => {
            this.getNewName(el);
            this.button_add_new.setAttribute('data-counter', this.counter);
        });

        if (this.area_new_insert) this.area_new_insert.appendChild(targetCopyElement);
    }

    getNewName(element) {
        let old_name = element.getAttribute('name');
        let new_name = old_name.replace('#counter#', this.counter);
        element.setAttribute('name', new_name);
    }
}

export default CopyFormElement;