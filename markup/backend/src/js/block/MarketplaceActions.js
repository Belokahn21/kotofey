import RestRequest from "../../../../frontend/src/js/tools/RestRequest";
import config from "../react/config";

export default class MarketplaceActions {
    constructor() {
        let data = {
            'js-marketplace-refresh-count': 'refresh',
        }

        let elements_refresh = document.querySelectorAll('.js-marketplace-refresh-count');
        if (elements_refresh) {
            elements_refresh.forEach(el => {
                el.onclick = this.refresh.bind(this);
            })
        }
    }

    refresh(event) {
        let element = event.target;
        let data = new FormData();

        let article = element.getAttribute('data-article');
        let amount = element.getAttribute('data-amount');

        if (article.length === 0 || amount.length === 0) {
            console.log('Артикул товара или количество не были переданы', article, amount);
            return false;
        }

        data.append('article', article);
        data.append('amount', amount);

        RestRequest.post(`${config.restMarketplace}refresh-count/`, {
            body: data
        }).then(data => {
            console.log(data);
        });
    }
}