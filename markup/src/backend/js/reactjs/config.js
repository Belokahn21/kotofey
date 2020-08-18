const url = location.protocol + '//' + location.hostname;
module.exports = {
	restCatalogGet: url + '/catalog/rest-backend/get/',
	restStatisticGet: url + '/statistic/rest-backend/get/',
	restMenuGet: url + '/menu/rest-backend/get/',
	restMenuFastGet: url + '/menu_fast/rest-backend/get/',
	restSearchGet: url + '/rest/product/get/'
};