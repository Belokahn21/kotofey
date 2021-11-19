import RestRequest from "../../../../frontend/src/js/tools/RestRequest";
import config from "../react/config";

export default class MarketplaceActions {
    constructor() {
        let data = {
            'js-marketplace-refresh-count': 'refresh',
        }

        console.log('demo 123');


        let element_refresh = document.querySelector('.js-marketplace-refresh-count');
        if (element_refresh) element_refresh.onclick = this.refresh.bind(this);
    }

    refresh(event) {
        console.log('demo ssss');
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


        console.log('demo 123');
        RestRequest.post(`${config.restMarketplace}refresh-count/`, {
            body: data
        }).then(data => {
            console.log(data);
        });
    }
}