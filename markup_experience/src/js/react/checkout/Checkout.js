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
import VariantDelivery from "./field/VariantDelivery";
import VariantPayment from "./field/VariantPayment";

class Checkout extends Component {


    constructor(props) {
        super(props);

        this.state = {
            promocode: null,
            excludePayments: [],
            delivery: [],
            payment: [],
            basket: [],
            errors: [],
            total: 0,
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
            }

            if (data.status === 200) {
                if (this.state.paymentId === 1) this.paymentService(data.id + 'test');

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

        if (this.state.promocode !== null) {
            total = total - Math.round(total * (this.state.promocode.discount / 100));
        }

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

    handleSelectPayment(event) {
        let current = event.target;
        this.setState({
            paymentId: current.value
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

    refreshPayment(arListPaymentId) {
        this.setState({
            excludePayments: arListPaymentId
        });
    }

    updatePoromocode(code) {
        this.setState({promocode: code});
    }

    render() {
        let buttonLabel = parseInt(this.state.paymentId) === 1 ? 'Оформить заказ и оплатить' : 'Оформить заказ';
        return (
            <div className="page__group-row">
                <div className="page__left">
                    <form className="checkout-form" onSubmit={this.submitForm.bind(this)}>
                        <div className="checkout-form__title">Укажите способ доставки</div>
                        <div className="checkout-form-variants">
                            {this.state.delivery.map((element, key) => {
                                return <VariantDelivery handleSelectDelivery={this.handleSelectDelivery.bind(this)} element={element}/>
                            })}
                        </div>


                        <div className="checkout-form__title">Промокод и бонусы</div>
                        <div className="checkout-form__group-row">
                            <PromocodeField promocode={this.state.promocode} updatePoromocode={this.updatePoromocode.bind(this)} refreshBasket={this.refreshBasket.bind(this)}/>
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
                            {this.state.payment.filter(element => !this.state.excludePayments.includes(element.id)).map((element, key) => {
                                return <VariantPayment handleSelectPayment={this.handleSelectPayment.bind(this)} element={element}/>
                            })}
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
