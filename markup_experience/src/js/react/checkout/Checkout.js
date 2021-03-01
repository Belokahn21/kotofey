import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import config from "../../config";
import Price from '../../tools/Price';

import AvailableDates from "./AvailableDates";
import CheckoutSummary from "./CheckoutSummary";

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


    refreshBasket(product_id) {
        let out = this.state.basket;
        console.log(out);

        out.map((el, key) => {
            if (el.id === product_id) {
                console.log('good ident');
                delete out[key];
            }
        });

        console.log(out);

        this.setState({
            basket: out
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

                                        <AvailableDates/>

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
                                        <input type="text" id="checkout-phone" className="js-mask-ru checkout-form__input" name="Order[phone]" placeholder="Ваш номер телефона" aria-required="true"/>
                                        <p className="help-block help-block-error"/>
                                    </div>
                                </label>
                                <label className="checkout-form__label" htmlFor="checkout-email">
                                    <div>Ваш электронный адрес*</div>
                                    <div className="form-group field-checkout-email required">
                                        <input type="text" id="checkout-email" className="checkout-form__input" name="Order[email]" placeholder="Ваш электронный адрес" aria-required="true"/>
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
                    <CheckoutSummary refreshBasket={this.refreshBasket.bind(this)} total={this.state.total} basket={this.state.basket}/>
                </div>
            </>
        );
    }
}


const checkout = document.querySelector('.page__group-row');
if (checkout) ReactDOM.render(<Checkout/>, checkout);