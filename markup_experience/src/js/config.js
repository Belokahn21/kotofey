let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1") url = 'http://local.kotofey.store'

const config = {
    restAddBasket: url + '/basket/rest/add/',
    restBasketGetCheckout: url + '/basket/rest/get-checkout/',
    restDeliveryGetCheckout: url + '/delivery/rest/get-checkout/',
    restPaymentGetCheckout: url + '/payment/rest/get-checkout/',
    restGetCatalog: url + '/catalog/rest/get/',
    restAddFavorite: url + '/favorite/rest/add/',
    restDeleteFavorite: url + '/favorite/rest/delete/',
    restDeleteBasket: url + '/basket/rest/delete/',
    ajaxActionGetMiniCartAmount: url + '/get-mini-cart-amount/',
    ajaxActionGetMiniCartCount: url + '/get-mini-cart-count/',
};


export default config;