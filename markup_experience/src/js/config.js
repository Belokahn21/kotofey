let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1") url = 'http://local.kotofey.store'

const config = {
    restFavorite: url + 'api/favorite/',
    restOrder: url + 'api/order/',
    restBasket: url + 'api/basket/',
    restDelivery: url + 'api/delivery/',
    restPayment: url + 'api/payment/',
    restDates: url + 'api/order/dates/',
    restGetCatalog: url + 'api/catalog/',
    ajaxActionGetMiniCartAmount: url + 'api/get-mini-cart-amount/',
    ajaxActionGetMiniCartCount: url + 'api/get-mini-cart-count/',
    restCatalog: url + 'api/catalog/',
    restBonus: url + 'api/bonus/',
    restPromocode: url + 'api/promocode/',
    restUser: url + 'api/user/',
    // sberbank payments
    restAcquiring: url + 'api/acquiring/',
};


export default config;