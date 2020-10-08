let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
    url = 'http://local.kotofey.store'

module.exports = {
    restCatalogGet: url + '/catalog/rest-backend/get/',
    restStatisticGet: url + '/statistic/rest-backend/get/',
    restMenuGet: url + '/menu/rest-backend/get/',
    restMenuFastGet: url + '/menu_fast/rest-backend/get/',
    restSearchGet: url + '/rest/product/get/',
    restUserGet: url + '/user/rest-backend/get/',
    restTodoAdd: url + '/todo/rest-backend/add/',
    restTodoGet: url + '/todo/rest-backend/get/'
};