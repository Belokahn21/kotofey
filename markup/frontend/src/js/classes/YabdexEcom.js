class YandexEcom {
    constructor(dataLayer) {
        this.dataLayer = dataLayer;
    }

    actionAddBasket(dataProduct) {
        this.dataLayer.push({
            "ecommerce": {
                "currencyCode": "RUB",
                "<actionType>": {
                    "actionField": 'add',
                    "products": [
                        dataProduct,
                    ]
                }
            }
        });
    }
}

export default YandexEcom;