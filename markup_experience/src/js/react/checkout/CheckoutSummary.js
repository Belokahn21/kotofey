import React, {Component} from "react";
import Price from "../../tools/Price";
import CheckoutBasket from "./CheckoutBasket";

class CheckoutSummary extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <>
                <div className="checkout-summary">
                    <a className="clear-basket" href="#" data-toggle="tooltip" data-placement="top" rel="tooltip" title="Очистить корзину"><i className="fas fa-trash-alt"/></a>
                    <div className="checkout-summary__info">
                        <div className="checkout-summary__title">Ваш заказ на сумму:</div>
                        <a className="checkout-summary__show-items" data-toggle="collapse" href="#collapseSummary" role="button" aria-expanded="false" aria-controls="collapseSummary">Посмотреть состав заказа</a>
                    </div>
                    <div className="checkout-summary__amount d-flex flex-row align-items-end">
                        <div className="js-product-calc-full-summary">{Price.format(this.props.total)}</div>
                        <div className="checkout-summary__currency">₽</div>
                    </div>
                </div>
                <div className="collapse show" id="collapseSummary">
                    <CheckoutBasket updateBasketItem={this.props.updateBasketItem} refreshBasket={this.props.refreshBasket} basket={this.props.basket} total={this.props.total}/>
                </div>
                <div className="checkout-reglament">
                    <div className="checkout-reglament__title">Обратите внимание!</div>
                    <div className="checkout-reglament__text">
                        <p>После оформления заказа, с вами свяжется менеджер для подтверждения заявки и уточнит сроки доставки (Обычно 1 час).</p>
                        <p>Доставка бесплатная при заказе на сумму от 500 рублей. Если ваш адрес дальше Барнаула советуем вам уточнить стоимость доставки у наших операторов.</p>
                        <p>Остались вопросы — <a href="mailto:info@kotofey.store">info@kotofey.store</a> или <a href="tel:89967026637" className="js-phone-mask">8 (996) 702 66-37</a></p>
                    </div>
                </div>
            </>
        );
    }

}

export default CheckoutSummary;