export default class MarketplaceActions {
    constructor() {
        let data = {
            'js-marketplace-refresh-count': 'refresh',
        }


        let element_refresh = document.querySelector('.js-marketplace-refresh-count');
        if (element_refresh) element_refresh.onclick = this.refresh.bind();
    }

    refresh() {
        console.log('refresh');
    }
}