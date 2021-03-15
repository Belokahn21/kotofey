import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import config from "../../config";

import CheckoutSummary from "./CheckoutSummary";
import HtmlHelper from "./html/HtmlHelper";
import TimeDeliveryField from "./field/TimeDeliveryField";
import PromocodeField from "./field/PromocodeField";
import UserBonusField from "./field/UserBonusField";
import DateDeliveryField from "./field/DateDeliveryField";
import CheckoutUserBonusAuth from "./CheckoutUserBonusAuth";
import Terminal from "../../tools/payment/terminal";
import RestRequest from "../../tools/RestRequest";

class Checkout extends Component {

    constructor(props) {
        super(props);

        this.state = {
            delivery: [],
            payment: [],
            basket: [],
            errors: [],
            total: 0,
            paymentId: 0,
            user: null
        };

        this.loadDelivery();
        this.loadPayment();
        this.loadBasket();
        this.loadUser();
    }

    loadUser() {
        if (!Number.isInteger(parseInt(this.props.userId))) return false;

        RestRequest.one(config.restUser, this.props.userId).then(data => {
            this.setState({
                user: data
            });
        });

    }

    submitForm(e) {
        e.preventDefault();
        const form = e.target;

        RestRequest.post(config.restOrder, {
            body: new FormData(form)
        }).then(data => {
            if (data.errors) {
                this.setState({
                    errors: data.errors
                });
            }

            if (data.status === 200) {
                if (this.state.paymentId === 1) this.handlePayment(data.id + 'test');

                form.reset();
                this.setState({
                    errors: []
                });
            }
        });
    }

    loadDelivery() {
        RestRequest.all(config.restDelivery + '?filter[active]=1').then(data => {
            this.setState({
                delivery: data
            });
        });
    }

    loadPayment() {
        RestRequest.all(config.restPayment + '?filter[active]=1').then(data => {
            this.setState({
                payment: data
            });
        });
    }

    loadBasket() {
        RestRequest.all(config.restBasket).then(data => {
            if (data.status === 200 && data.items.length > 0) {
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


    handlePayment(order_id) {
        const terminal = new Terminal();
        terminal.registerOrder(order_id).then(data => {
            if (data.formUrl !== undefined) {

                window.location.href = data.formUrl; // by click link
                // window.open(data.formUrl, '_blank'); // new tab
                // window.location.replace(data.formUrl); // as http redirect
            }
        });
    }

    handleSelectPayment(event) {
        let current = event.target;
        this.setState({
            paymentId: current.value
        });
    }

    render() {
        let buttonLabel = parseInt(this.state.paymentId) === 1 ? 'Оформить заказ и оплатить' : 'Оформить заказ';
        return (
            <div className="page__group-row">
                <div className="page__left">
                    <form className="checkout-form" onSubmit={this.submitForm.bind(this)}>
                        <div className="checkout-form__title">Укажите способ доставки</div>
                        <div className="checkout-form-variants">
                            <div className="form-group field-order-delivery_id">
                                <label className="control-label">Способ доставки</label>
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


                        <div className="checkout-form__title">Промокод и бонусы</div>
                        <div className="checkout-form__group-row">
                            <PromocodeField/>
                            {this.state.user !== null ? <UserBonusField accountId={this.state.user.phone}/> : <CheckoutUserBonusAuth/>}
                        </div>


                        <div className="checkout-form__title">Время и дата доставки</div>
                        <div className="checkout-form__group-row">
                            <DateDeliveryField/>
                            <TimeDeliveryField/>
                        </div>


                        <div className="checkout-form__title">Укажите ваши данные</div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "phone", title: "Ваш номер телефона*", placeholder: "Ваш номер телефона*", class: 'js-mask-ru'}}/>
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "email", title: "Ваш электронный адрес*", placeholder: "Ваш электронный адрес*"}}/>
                        </div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "city", title: "Город", placeholder: "Город"}}/>
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "street", title: "Улица", placeholder: "Улица"}}/>
                        </div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "number_home", title: "Номер дома", placeholder: "Номер дома"}}/>
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "entrance", title: "Подъезд", placeholder: "Подъезд"}}/>
                        </div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "floor_house", title: "Этаж", placeholder: "Этаж"}}/>
                            <HtmlHelper errors={this.state.errors} element="input" modelName="Order" options={{name: "number_appartament", title: "Квартира", placeholder: "Квартира"}}/>
                        </div>
                        <label className="checkout-form__label" htmlFor="checkout-comment">
                            <HtmlHelper errors={this.state.errors} element="textarea" modelName="Order" options={{name: "comment", title: "Комментарий к заказу", placeholder: "Ваши пожелания"}}/>
                        </label>


                        <div className="checkout-form-variants">
                            <div className="form-group field-order-payment_id">
                                <label className="control-label">Способ оплаты</label>
                                <div id="order-payment_id" role="radiogroup">
                                    {this.state.payment.map((element, key) => {
                                        return <div key={key}>
                                            <input onChange={this.handleSelectPayment.bind(this)} className="checkbox-budget" id={"budgetpayment-" + element.id} type="radio" defaultValue={element.id} name="Order[payment_id]"/>
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
                        <button type="submit" className="add-basket checkout-form__submit">{buttonLabel}</button>
                    </form>
                </div>
                <div className="page__right">
                    <CheckoutSummary refreshBasket={this.refreshBasket.bind(this)} total={this.state.total} basket={this.state.basket}/>
                </div>
            </div>
        );
    }

}


const checkout = document.querySelector('.checkout-react');

if (checkout) {

    const userId = checkout.getAttribute('data-user');

    ReactDOM.render(<Checkout userId={userId}/>, checkout);
}
