if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
	module.exports = {
		restStatisticGet: 'http://local.kotofey.store/statistic/rest-backend/get/',
		restMenuGet: 'http://local.kotofey.store/menu/rest-backend/get/',
		restMenuFastGet: 'http://local.kotofey.store/menu_fast/rest-backend/get/',
		restSearchGet: "http://local.kotofey.store/rest/product/get/"
	};
} else {
	module.exports = {
		restStatisticGet: 'https://kotofey.store/statistic/rest-backend/get/',
		restMenuGet: 'https://kotofey.store/menu/rest-backend/get/',
		restMenuFastGet: 'https://kotofey.store/menu_fast/rest-backend/get/',
		restSearchGet: "https://kotofey.store/rest/product/get/"
	};
}
