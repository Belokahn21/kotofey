import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import config from "../../config";
import Price from '../../tools/Price';

class Checkout extends Component {

    constructor() {
        super();

        this.state = {
            delivery: [],
            payment: [],
            basket: [],
            total: 0,
        };

        this.loadDelivery();
        this.loadPayment();
        this.loadBasket();
    }

    submitForm(e) {
        console.log(e);
        e.preventDefault();
    }

    loadDelivery() {
        fetch(config.restDeliveryGetCheckout).then(response => response.json()).then(data => {
            this.setState({
                delivery: data
            });
        });
    }

    loadPayment() {
        fetch(config.restPaymentGetCheckout).then(response => response.json()).then(data => {
            this.setState({
                payment: data
            });
        });
    }

    loadBasket() {
        fetch(config.restBasketGetCheckout).then(response => response.json()).then(data => {
            this.setState({
                basket: data
            });

            this.calcTotal();
        });
    }

    calcTotal() {
        let total = 0;
        this.state.basket.map((element, key) => {
            total += parseInt(element.price);
        });

        this.setState({
            total: total
        });
    }

    render() {
        return (
            <>
                <div className="page__left">
                    <form className="checkout-form" onSubmit={this.submitForm.bind(this)}>
                        <div className="checkout-form__title">Укажите способ доставки</div>
                        <div className="checkout-form-variants">
                            <div className="form-group field-order-delivery_id">
                                <label className="control-label">Способ доставки</label>
                                <input type="hidden" name="Order[delivery_id]" value=""/>
                                <div id="order-delivery_id" role="radiogroup">

                                    {this.state.delivery.map((element, key) => {
                                        return <>
                                            <input key={"i1" + key} className="checkbox-budget" id={"budget-" + element.id} value="2" type="radio" name="Order[delivery_id]"/>
                                            <label key={"l1" + key} className="for-checkbox-budget checkout-form-variants__item" htmlFor={"budget-" + element.id}>
                                                <span className="checkout-form-variants__card">
                                                    <div className="checkout-form-variants__label">{element.name}</div>
                                                    <img className="checkout-form-variants__icon" src={element.imageUrl}/>
                                                </span>
                                            </label>
                                        </>
                                    })}

                                </div>
                                <p className="help-block help-block-error"/>
                            </div>
                        </div>
                        <div className="checkout-form__title">Промокод и бонусы
                            <div className="checkout-form__group-row">
                                <label className="checkout-form__label" htmlFor="checkout-phone">
                                    <div>Промокод</div>
                                    <div className="form-group field-order-promocode has-success">
                                        <input type="text" id="order-promocode" className="checkout-form__input js-validate-promocode" name="Order[promocode]" placeholder=""/>
                                        <input type="hidden" className="js-promocode-amount" name="promocode-discount" value=""/>
                                        <div className="checkout-form-promocode">Ваш промокод: <span className="checkout-form-promocode__code"/>
                                            <span className="checkout-form-promocode__discount">
                                            </span>
                                        </div>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>

                                <label className="checkout-form__label" htmlFor="checkout-phone">
                                    <div className="form-group field-order-bonus">
                                        <div className="checkout-form-label-group">
                                            <div>Бонусы</div>
                                            <div>Доступно: 0 бонуса</div>
                                        </div>
                                        <input type="text" id="order-bonus" className="checkout-form__input js-validate-promocode" name="Order[bonus]" placeholder="Списать бонусы"/>
                                        <input type="range" id="js-bonus-input" className="js-select-user-bonus " name="bonus" data-min="0" data-from="0" data-max="0" tabIndex="-1" readOnly=""/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div className="checkout-form__title">Время и дата доставки
                            <div className="checkout-form__group-row">
                                <label className="checkout-form__label" htmlFor="checkout-date-delivery">
                                    <div>Дата доставки*</div>
                                    <div className="form-group field-checkout-date-delivery required">
                                        <input type="text" id="checkout-date-delivery" className="js-datepicker checkout-form__input" name="OrderDate[date]" placeholder="Дата доставки" data-min="1614546000" aria-required="true"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                                <label className="checkout-form__label" htmlFor="checkout-time-delivery">
                                    <div>Время доставки*</div>
                                    <div className="form-group field-checkout-time-delivery required">

                                        <select id="checkout-time-delivery" className="checkout-form__select" name="OrderDate[time]" aria-required="true">
                                            <option value="">Время доставки</option>
                                            <option value="0">1.02.2020</option>
                                            <option value="1">2.02.2020</option>
                                            <option value="2">3.02.2020</option>
                                            <option value="3">4.02.2020</option>
                                            <option value="4">5.02.2020</option>
                                            <option value="5">6.02.2020</option>
                                            <option value="6">7.02.2020</option>
                                            <option value="7">8.02.2020</option>
                                            <option value="8">9.02.2020</option>
                                            <option value="9">10.02.2020</option>
                                            <option value="10">11.02.2020</option>
                                            <option value="11">12.02.2020</option>
                                            <option value="12">13.02.2020</option>
                                            <option value="13">14.02.2020</option>
                                            <option value="14">15.02.2020</option>
                                            <option value="15">16.02.2020</option>
                                            <option value="16">17.02.2020</option>
                                            <option value="17">18.02.2020</option>
                                            <option value="18">19.02.2020</option>
                                        </select>

                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div className="checkout-form__title">Укажите ваши данные
                            <div className="checkout-form__group-row">
                                <label className="checkout-form__label" htmlFor="checkout-phone">
                                    <div>Ваш номер телефона*</div>
                                    <div className="form-group field-checkout-phone required">
                                        <input type="text" id="checkout-phone" className="js-mask-ru checkout-form__input" name="Order[phone]" value="9059858726" placeholder="Ваш номер телефона" aria-required="true"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                                <label className="checkout-form__label" htmlFor="checkout-email">
                                    <div>Ваш электронный адрес*</div>
                                    <div className="form-group field-checkout-email required">
                                        <input type="text" id="checkout-email" className="checkout-form__input" name="Order[email]" value="popugau@gmail.com" placeholder="Ваш электронный адрес" aria-required="true"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                            </div>
                            <div className="checkout-form__group-row">
                                <label className="checkout-form__label" htmlFor="checkout-city">
                                    <div>Город*</div>
                                    <div className="form-group field-checkout-city">
                                        <input type="text" id="checkout-city" className="checkout-form__input" name="Order[city]" value="Барнаул" placeholder="Город"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                                <label className="checkout-form__label" htmlFor="checkout-street">
                                    <div>Улица*</div>
                                    <div className="form-group field-checkout-street">
                                        <input type="text" id="checkout-street" className="checkout-form__input" name="Order[street]" placeholder="Улица"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                            </div>
                            <div className="checkout-form__group-row">
                                <label className="checkout-form__label" htmlFor="checkout-number_home">
                                    <div>Номер дома*</div>
                                    <div className="form-group field-checkout-number_home">
                                        <input type="text" id="checkout-number_home" className="checkout-form__input" name="Order[number_home]" placeholder="Номер дома"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                                <label className="checkout-form__label" htmlFor="checkout-entrance">
                                    <div>Подьезд*</div>
                                    <div className="form-group field-checkout-entrance">
                                        <input type="text" id="checkout-entrance" className="checkout-form__input" name="Order[entrance]" placeholder="Подьезд"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                            </div>
                            <div className="checkout-form__group-row">
                                <label className="checkout-form__label" htmlFor="checkout-floor_house">
                                    <div>Этаж*</div>
                                    <div className="form-group field-checkout-floor_house">
                                        <input type="text" id="checkout-floor_house" className="checkout-form__input" name="Order[floor_house]" placeholder="Этаж"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                                <label className="checkout-form__label" htmlFor="checkout-number_appartament">
                                    <div>Квартира*</div>
                                    <div className="form-group field-checkout-number_appartament">

                                        <input type="text" id="checkout-number_appartament" className="checkout-form__input" name="Order[number_appartament]" placeholder="Номер квартиры"/>

                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                            </div>
                            <label className="checkout-form__label" htmlFor="checkout-comment">
                                <div>Ваши пожелания*</div>
                                <div className="form-group field-checkout-comment">

                                    <textarea id="checkout-comment" className="checkout-form__textarea" name="Order[comment]" placeholder="Комментарий к заказу"/>

                                    <p className="help-block help-block-error"/>
                                </div>
                            </label>
                        </div>
                        <div className="checkout-form-variants">
                            <div className="form-group field-order-payment_id">
                                <label className="control-label">Способ оплаты</label>
                                <input type="hidden" name="Order[payment_id]" value=""/>
                                <div id="order-payment_id" role="radiogroup">
                                    {this.state.payment.map((element, key) => {
                                        return <>
                                            <input key={"i2" + key} className="checkbox-budget" id={"budgetpayment-" + element.id} value="2" type="radio" name="Order[payment_id]"/>
                                            <label key={"l2" + key} className="for-checkbox-budget checkout-form-variants__item" htmlFor={"budgetpayment-" + element.id}>
                                                <span className="checkout-form-variants__card">
                                                <div className="checkout-form-variants__label">{element.name}</div>
                                                    <img className="checkout-form-variants__icon" src={element.imageUrl}/>
                                                </span>
                                            </label>
                                        </>
                                    })}
                                </div>
                                <p className="help-block help-block-error"/>
                            </div>
                        </div>
                        <button type="submit" className="add-basket checkout-form__submit">Подтвердить заказ</button>
                    </form>
                </div>
                <div className="page__right">
                    <div className="checkout-summary">
                        <a className="clear-basket" href="#" data-toggle="tooltip" data-placement="top" rel="tooltip" title="Очистить корзину"><i className="fas fa-trash-alt"/></a>
                        <div className="checkout-summary__info">
                            <div className="checkout-summary__title">Ваш заказ на сумму:</div>
                            <a className="checkout-summary__show-items" data-toggle="collapse" href="#collapseSummary" role="button" aria-expanded="false" aria-controls="collapseSummary">Посмотреть состав заказа</a>
                        </div>
                        <div className="checkout-summary__amount d-flex flex-row align-items-end">
                            <div className="js-product-calc-full-summary">{Price.format(this.state.total)}</div>
                            <div className="checkout-summary__currency">₽</div>
                        </div>
                    </div>
                    <div className="collapse show" id="collapseSummary">
                        <ul className="light-checkout-list">
                            {this.state.basket.map((element, key) => {
                                return <>
                                    <li className="light-checkout-list__item" key={key}>
                                        <a className="clear-basket js-remove-basket-item" href="#" data-toggle="tooltip" rel="tooltip" data-product-id={element.id} data-placement="right" title="" data-original-title="Удалить товар из корзины">
                                            <i className="fas fa-trash-alt" aria-hidden="true"/>
                                        </a>
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
                                                        <input name="count" type="text" className="product-calc__count js-product-calc-amount" value="1" placeholder="1"/>
                                                        <button className="product-calc__control product-calc__plus js-product-calc-plus" type="button">+</button>

                                                        <div className="product-calc__price-info">
                                                            <div className="product-calc__price-info-normal">Цена за товар: {element.price}₽</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </>
                            })}
                        </ul>
                    </div>
                    <div className="checkout-reglament">
                        <div className="checkout-reglament__title">Обратите внимание!</div>
                        <div className="checkout-reglament__text">
                            <p>После оформления заказа, с вами свяжется менеджер для подтверждения заявки и уточнит сроки доставки (Обычно 1 час).</p>
                            <p>Доставка бесплатная при заказе на сумму от 500 рублей. Если ваш адрес дальше Барнаула советуем вам уточнить стоимость доставки у наших операторов.</p>
                            <p>Остались вопросы — <a href="mailto:info@kotofey.store">info@kotofey.store</a> или <a href="tel:89967026637" className="js-phone-mask">8 (996) 702 66-37</a></p>
                        </div>
                    </div>
                </div>
            </>
        );
    }
}


const checkout = document.querySelector('.page__group-row');
if (checkout) ReactDOM.render(<Checkout/>, checkout);