import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import config from "../../config";

import CheckoutSummary from "./CheckoutSummary";
import HtmlHelper from "./html/HtmlHelper";
import TimeDeliveryField from "./field/TimeDeliveryField";
import PromocodeField from "./field/PromocodeField";
import UserBonusField from "./field/UserBonusField";
import DateDeliveryField from "./field/DateDeliveryField";

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
        e.preventDefault();

        const form = e.target;
        console.log(form);

        fetch(config.restAddOrder, {
            method: 'POST',
            body: new FormData(form)
        }).then(response => response.json()).then(data => {
            console.log(data);
        });
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
        fetch(config.restBasketGet).then(response => response.json()).then(data => {
            if (data.status == 200 && data.items.length > 0) {
                this.setState({
                    basket: data.items
                });

                this.calcTotal();
            }
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

        out.map((product, key) => {
            if (parseInt(product.id) === parseInt(product_id)) out.splice(key, 1);
        });

        this.setState({
            basket: out
        });

        this.calcTotal();
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
                                <input type="hidden" name="Order[delivery_id]"/>
                                <div id="order-delivery_id" role="radiogroup">
                                    {this.state.delivery.map((element, key) => {
                                        return <div key={key}>
                                            <input className="checkbox-budget" id={"budget-" + element.id} type="radio" name="Order[delivery_id]"/>
                                            <label className="for-checkbox-budget checkout-form-variants__item" htmlFor={"budget-" + element.id}>
                                                <span className="checkout-form-variants__card">
                                                    <div className="checkout-form-variants__label">{element.name}</div>
                                                    <img className="checkout-form-variants__icon" src={element.imageUrl}/>
                                                </span>
                                            </label>
                                        </div>
                                    })}
                                </div>
                                <p className="help-block help-block-error"/>
                            </div>
                        </div>
                        <div className="checkout-form__title">Промокод и бонусы
                            <div className="checkout-form__group-row">
                                <PromocodeField />
                                <UserBonusField/>
                            </div>
                        </div>
                        <div className="checkout-form__title">Время и дата доставки
                            <div className="checkout-form__group-row">
                                <DateDeliveryField />
                                <TimeDeliveryField/>
                            </div>
                        </div>
                        <div className="checkout-form__title">Укажите ваши данные
                            <div className="checkout-form__group-row">
                                <HtmlHelper element="input" modelName="Order" options={{name: "phone", title: "Ваш номер телефона*", placeholder: "Ваш номер телефона*", class: 'js-mask-ru'}}/>
                                <HtmlHelper element="input" modelName="Order" options={{name: "email", title: "Ваш электронный адрес*", placeholder: "Ваш электронный адрес*"}}/>
                            </div>
                            <div className="checkout-form__group-row">
                                <HtmlHelper element="input" modelName="Order" options={{name: "city", title: "Город", placeholder: "Город"}}/>
                                <HtmlHelper element="input" modelName="Order" options={{name: "street", title: "Улица", placeholder: "Улица"}}/>
                            </div>
                            <div className="checkout-form__group-row">
                                <HtmlHelper element="input" modelName="Order" options={{name: "number_home", title: "Номер дома", placeholder: "Номер дома"}}/>
                                <HtmlHelper element="input" modelName="Order" options={{name: "entrance", title: "Подъезд", placeholder: "Подъезд"}}/>
                            </div>
                            <div className="checkout-form__group-row">
                                <HtmlHelper element="input" modelName="Order" options={{name: "floor_house", title: "Этаж", placeholder: "Этаж"}}/>
                                <HtmlHelper element="input" modelName="Order" options={{name: "number_appartament", title: "Квартира", placeholder: "Квартира"}}/>
                            </div>
                            <label className="checkout-form__label" htmlFor="checkout-comment">
                                <HtmlHelper element="textarea" modelName="Order" options={{name: "comment", title: "Комментарий к заказу", placeholder: "Ваши пожелания"}}/>
                            </label>
                        </div>
                        <div className="checkout-form-variants">
                            <div className="form-group field-order-payment_id">
                                <label className="control-label">Способ оплаты</label>
                                <input type="hidden" name="Order[payment_id]"/>
                                <div id="order-payment_id" role="radiogroup">
                                    {this.state.payment.map((element, key) => {
                                        return <div key={key}>
                                            <input className="checkbox-budget" id={"budgetpayment-" + element.id} type="radio" name="Order[payment_id]"/>
                                            <label className="for-checkbox-budget checkout-form-variants__item" htmlFor={"budgetpayment-" + element.id}>
                                                <span className="checkout-form-variants__card">
                                                <div className="checkout-form-variants__label">{element.name}</div>
                                                    <img className="checkout-form-variants__icon" src={element.imageUrl}/>
                                                </span>
                                            </label>
                                        </div>
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