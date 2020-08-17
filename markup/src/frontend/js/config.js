const url = location.protocol + '//' + location.hostname;
module.exports = {
    restAddBasket: url + '/basket/rest/add/',
    restGetCatalog: url + '/catalog/rest/get/',
    restAddFavorite: url + '/favorite/rest/add/',
    restDeleteFavorite: url + '/favorite/rest/delete/',
}