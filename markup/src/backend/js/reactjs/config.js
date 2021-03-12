let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
    url = 'http://local.kotofey.store';

module.exports = {
    restCatalog: url + '/backend/api/catalog/',
    restStatistic: url + '/backend/api/statistic/',
    restMenu: url + '/backend/api/menu/',
    restMenuFast: url + '/backend/api/menu_fast/',
    restSearchGet: url + '/rest/product/get/',
    restUserGet: url + '/user/rest-backend/get/',
    restTodoGet: url + '/todo/rest-backend/get/',
    restCdekCity: url + '/cdek/rest-city/get/',
    restCdekSize: url + '/cdek/rest-size/get/',
    restCdekDeliveryPrice: url + '/cdek/rest-calculator/get/',
    restCatalogFrontGet: url + '/catalog/rest/get/',

    restTodoAdd: url + '/todo/rest-backend/add/',

    ajaxSaveProductMark: url + '/ajax/mark/',
};