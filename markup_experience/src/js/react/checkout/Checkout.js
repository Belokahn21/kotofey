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
import Variants from "./html/widget/Variants";
import DeliveryService from "./DeliveryService";
import BuildQuery from "../../tools/BuildQuery";

class Checkout extends Component {
    constructor(props) {
        super(props);

        this.modelName = 'Order';

        this.state = {
            promocode: null,
            excludePayments: [],
            delivery: [],
            payment: [],
            basket: [],
            errors: [],
            total: 0,
            usedBonus: 0,
            paymentId: 0,
            deliveryId: 0,
            user: null
        };
    }

    componentDidMount() {
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

                this.moveToElement(document.querySelectorAll('[aria-invalid="true"]')[0]);
            }

            if (data.status === 200) {
                if (parseInt(this.state.paymentId) === 1) this.paymentService(data.id);

                form.reset();
                this.setState({
                    errors: []
                });
            }
        });
    }

    moveToElement(el) {
        if (!el) return false;

        el.scrollIntoView({
            behavior: 'smooth'
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

        if (this.state.usedBonus > 0) total -= parseInt(this.state.usedBonus);

        if (this.state.promocode !== null) total = total - Math.round(total * (this.state.promocode.discount / 100));

        if (total < 0) total = 0;

        if (total < 500) total += 100;

        this.setState({
            total: total
        });
    }

    refreshBasket(product_id) {
        let basketItems = this.state.basket;

        basketItems.map((product, key) => {
            if (parseInt(product.id) === parseInt(product_id)) basketItems.splice(key, 1);
        });

        this.setState({
            basket: basketItems
        });

        this.calcTotal();
    }

    paymentService(order_id) {
        const terminal = new Terminal();
        terminal.registerOrder(order_id).then(data => {
            if (data.formUrl !== undefined) {
                window.location.href = data.formUrl; // by click link
                // window.open(data.formUrl, '_blank'); // new tab
                // window.location.replace(data.formUrl); // as http redirect
            }
        });
    }

    handleSelectDelivery(event) {
        let current = event.target;
        let deliveryId = parseInt(current.value);

        this.setState({
            deliveryId: deliveryId
        });


        if (deliveryId === 1) {
            this.refreshPayment([2, 4]);
        } else {
            this.refreshPayment([]);
        }
    }

    handleSelectPayment(event) {
        let current = event.target;
        this.setState({
            paymentId: current.value
        });
    }

    refreshPayment(arListPaymentId) {
        this.setState({
            excludePayments: arListPaymentId
        });
    }

    updatePoromocode(code) {
        this.setState({promocode: code});
    }

    unsetError(attribute) {
        let errors = this.state.errors;

        errors[attribute] = null;

        this.setState({errors: errors})
    }

    render() {
        let buttonLabel = parseInt(this.state.paymentId) === 1 ? 'Оформить заказ и оплатить' : 'Оформить заказ', deliveryService;

        if (parseInt(this.state.deliveryId) === 1) {
            deliveryService = <DeliveryService/>
        }

        return (
            <div className="page__group-row">
                <div className="page__left">
                    <form className="checkout-form" onSubmit={this.submitForm.bind(this)}>
                        <div className="checkout-form__title">Укажите способ доставки</div>

                        <Variants errors={this.state.errors} unsetError={this.unsetError.bind(this)} modelName={this.modelName} attribute="delivery_id" handlerSelect={this.handleSelectDelivery.bind(this)} models={this.state.delivery}/>

                        {/*{deliveryService}*/}


                        <div className="checkout-form__title">Время и дата доставки</div>
                        <div className="checkout-form__group-row">
                            <DateDeliveryField errors={this.state.errors}/>
                            <TimeDeliveryField errors={this.state.errors}/>
                        </div>


                        <div className="checkout-form__title">Укажите ваши данные</div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "phone", title: "Ваш номер телефона*", placeholder: "Ваш номер телефона*", class: 'js-mask-ru'}}/>
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "email", title: "Ваш электронный адрес*", placeholder: "Ваш электронный адрес*"}}/>
                        </div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "city", title: "Город", placeholder: "Город"}}/>
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "street", title: "Улица", placeholder: "Улица"}}/>
                        </div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "number_home", title: "Номер дома", placeholder: "Номер дома"}}/>
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "entrance", title: "Подъезд", placeholder: "Подъезд"}}/>
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "floor_house", title: "Этаж", placeholder: "Этаж"}}/>
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "number_appartament", title: "Квартира", placeholder: "Квартира"}}/>
                        </div>
                        <label className="checkout-form__label" htmlFor="checkout-comment">
                            <HtmlHelper errors={this.state.errors} element="textarea" modelName={this.modelName} options={{name: "comment", title: "Комментарий к заказу", placeholder: "Ваши пожелания"}}/>
                        </label>


                        <div className="checkout-form__title">Укажите способ оплаты</div>
                        <Variants unsetError={this.unsetError.bind(this)} errors={this.state.errors} modelName={this.modelName} attribute="payment_id" handlerSelect={this.handleSelectPayment.bind(this)} models={this.state.payment.filter(element => !this.state.excludePayments.includes(element.id))}/>


                        <div className="checkout-form__title">Промокод и бонусы</div>
                        <div className="checkout-form__group-row">
                            <PromocodeField promocode={this.state.promocode} updatePoromocode={this.updatePoromocode.bind(this)} refreshBasket={this.refreshBasket.bind(this)}/>
                            {this.state.user !== null ? <UserBonusField usedBonus={this.state.usedBonus} refreshBasket={this.refreshBasket.bind(this)} updateUsedBonus={(value) => this.setState({usedBonus: value})} accountId={this.state.user.phone}/> : <CheckoutUserBonusAuth/>}
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
