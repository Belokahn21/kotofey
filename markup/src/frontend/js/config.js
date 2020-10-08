let url = location.protocol + '//' + location.hostname;

if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
    url = 'http://local.kotofey.store'

module.exports = {
    restAddBasket: url + '/basket/rest/add/',
    restGetCatalog: url + '/catalog/rest/get/',
    restAddFavorite: url + '/favorite/rest/add/',
    restDeleteFavorite: url + '/favorite/rest/delete/',
    restDeleteBasket: url + '/basket/rest/delete/',
}