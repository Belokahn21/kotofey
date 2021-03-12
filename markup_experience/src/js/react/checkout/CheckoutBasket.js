import React, {Component} from 'react';
import config from "../../config";
import Price from "../../tools/Price";
import RestRequest from "../../tools/RestRequest";

class CheckoutBasket extends Component {
    constructor(props) {
        super(props);
    }

    delete(event) {
        const element = event.target;
        const product_id = element.getAttribute('data-product-id');

        if (!product_id) return false;

        RestRequest.delete(config.restBasket, product_id).then(data => {
            this.props.refreshBasket(product_id);
        });
    }

    render() {
        return (
            <ul className="light-checkout-list">
                {this.props.basket.map((element, key) => {
                    return <li className="light-checkout-list__item" key={key}>
                        <div className="clear-basket" onClick={this.delete.bind(this)} data-toggle="tooltip" rel="tooltip" data-product-id={element.id} data-placement="right" title="" data-original-title="Удалить товар из корзины">
                            <i className="fas fa-trash-alt" aria-hidden="true"/>
                        </div>
                        <img alt={element.name} title={element.name} className="light-checkout-list__image" src={element.imageUrl}/>
                        <div className="light-checkout-list__info">
                            <div className="light-checkout-list__title">
                                <a className="light-checkout-list__link" href={element.detailUrl}>{element.name}</a>
                            </div>
                            <div className="light-checkout-list__article">Артикул: {element.article}</div>
                        </div>
                        <div itemProp="offers" itemScope="" itemType="http://schema.org/Offer">
                            <form className="product-calc js-product-calc">
                                <input type="hidden" readOnly="" name="product_id" value={element.id}/>
                                <div className="product-calc__control-group">
                                    <input type="hidden" name="count" className="product-calc__count js-product-calc-price" value={element.id}/>
                                    <div className="div">
                                        <button className="product-calc__control product-calc__minus js-product-calc-minus" type="button">-</button>
                                        <input name="count" type="text" className="product-calc__count js-product-calc-amount" defaultValue="1" placeholder="1"/>
                                        <button className="product-calc__control product-calc__plus js-product-calc-plus" type="button">+</button>

                                        <div className="product-calc__price-info">
                                            <div className="product-calc__price-info-normal">Цена за товар: {Price.format(element.price)}₽</div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                })}
            </ul>
        );
    }
}

export default CheckoutBasket;