let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1") url = 'http://local.kotofey.store'

const config = {
    restAddBasket: url + '/basket/rest/add/',
    restAddFavorite: url + '/favorite/rest/add/',
    restAddOrder: url + '/order/rest/add/',

    restBasketGet: url + '/basket/rest/get/',
    restDeliveryGetCheckout: url + '/delivery/rest/get-checkout/',
    restPaymentGetCheckout: url + '/payment/rest/get-checkout/',
    restGetDates: url + '/order/rest/get-dates/',
    restGetCatalog: url + '/catalog/rest/get/',
    ajaxActionGetMiniCartAmount: url + '/get-mini-cart-amount/',
    ajaxActionGetMiniCartCount: url + '/get-mini-cart-count/',
    restCatalogFrontGet: url + '/catalog/rest/get/',
    restBonusGet: url + '/bonus/rest/get/',


    restDeleteFavorite: url + '/favorite/rest/delete/',
    restDeleteBasket: url + '/basket/rest/delete/',
};


export default config;