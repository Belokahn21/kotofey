let url = location.protocol + '//' + location.hostname + '/';

if (location.hostname === "localhost" || location.hostname === "127.0.0.1") url = 'http://local.kotofey.store/';

const config = {
    restCompare: url + 'api/compare/',
    restCompareMixed: url + 'api/compare/mixed/',
    restFavorite: url + 'api/favorite/',
    restOrder: url + 'api/order/',
    restFastOrder: url + 'api/order/fast/',
    restOrderRepeat: url + 'api/order/repeat/',
    restBasket: url + 'api/basket/',
    restDelivery: url + 'api/delivery/',
    restDeliveryService: url + 'api/delivery/service/',
    restDeliveryCalculate: url + 'api/delivery/calculate/',
    restDeliveryCleanAddress: url + 'api/delivery/clean-address/',
    restPayment: url + 'api/payment/',
    restDates: url + 'api/order/dates/',
    ajaxActionGetMiniCartAmount: url + 'get-mini-cart-amount/',
    ajaxActionGetMiniCartCount: url + 'get-mini-cart-count/',
    restCatalog: url + 'api/catalog/',
    restBonus: url + 'api/bonus/',
    restPromocode: url + 'api/promocode/',
    restUser: url + 'api/user/',
    // sberbank payments
    restAcquiring: url + 'api/acquiring/',
    restAcquiringOrder: url + 'api/acquiring/order/',
    // pets
    restAnimal: url + 'api/pets/animal/',
    restBreeds: url + 'api/pets/breed/',
    restPetCalculator: url + 'api/pets/calculate/',
};


export default config;