import RestRequest from "../tools/RestRequest";
import config from "../config";

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
        let element = e.target;
        e.preventDefault();
        let data = new FormData();
        data.append('product_id', element.getAttribute('data-id'));

        RestRequest.post(config.restCompare, {
            body: data
        }).then(data => {
            console.log(data);
        });
    }
}

export default Compare;