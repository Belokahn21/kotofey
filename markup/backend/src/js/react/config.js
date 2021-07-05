let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
    url = 'http://local.kotofey.store';

module.exports = {
    restOrderCustomer: url + '/backend/api/order/customer/',
    restDeliveryCalculate: url + '/backend/api/delivery/calculate/',
    restCdn: url + '/backend/api/cdn/',
    restMedia: url + '/backend/api/media/',
    restMediaUpload: url + '/backend/api/media/upload/',
    restCatalog: url + '/backend/api/catalog/',
    restCatalogFill: url + '/backend/api/catalog/fill/',
    restPropertiesProductValues: url + '/backend/api/catalog/properties-product-values/',
    restStatistic: url + '/backend/api/statistic/',
    restMenu: url + '/backend/api/menu/',
    restMenuFast: url + '/backend/api/menu_fast/',
    restSearchGet: url + '/rest/product/get/',
    restUser: url + '/backend/api/user/',
    restCdekCity: url + '/cdek/rest-city/get/',
    restCdekSize: url + '/cdek/rest-size/get/',
    restCdekDeliveryPrice: url + '/cdek/rest-calculator/get/',
    restCatalogFrontGet: url + '/catalog/rest/get/',
    restTodo: url + '/backend/api/todo/',
    ajaxSaveProductMark: url + '/ajax/mark/',
};