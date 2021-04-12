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
import Input from "./html/Input";
import Error from "./html/Error";

class Checkout extends Component {
    constructor(props) {
        super(props);

        this.modelName = 'Order';
        this.billingModelName = 'UserBilling';
        this.patchTimerEx, this.cleanAddressTimerEx;
        this.cleanAddressTimer = 1000;

        this.state = {
            order: null,
            promocode: null,
            deliveryAddress: [],
            excludePayments: [],
            delivery: [],
            payment: [],
            basket: [],
            errors: [],
            total: 0,
            usedBonus: 0,
            paymentId: 0,
            deliveryId: 0,
            user: null,
            finish: false,
            selectedAddress: null,
            addr_index: "",
            addr_city: "",
            addr_street: "",
            addr_home: "",
            addr_room: "",
            addr_pouch: "",
            addr_floor: "",
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
                if (parseInt(this.state.paymentId) === 1) {
                    this.paymentService(data.data.order.id);
                    return true;
                }

                form.reset();
                this.setState({
                    errors: [],
                    finish: true,
                    order: data.data.order
                });
                this.moveToElement(document.querySelector('.checkout-react')[0]);
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
            total += parseInt(element.price) * parseInt(element.count);
        });

        if (this.state.usedBonus > 0) total -= parseInt(this.state.usedBonus);

        if (this.state.promocode !== null) total = total - Math.round(total * (this.state.promocode.discount / 100));

        if (total < 0) total = 0;

        // if (total < 500) total += 100;

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

    updateBasketItem(product_id, count) {
        let basketItems = this.state.basket;

        basketItems.map((product, key) => {
            if (parseInt(product.id) === parseInt(product_id)) {
                basketItems[key].count = count;
            }
        });


        if (this.patchTimerEx) clearTimeout(this.patchTimerEx);
        this.patchTimerEx = setTimeout(() => {
            RestRequest.update(config.restBasket, {
                body: JSON.stringify(basketItems)
            }).then(data => {
                console.log(data);
            });
        }, 500);


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

    handleAddress(event) {
        if (this.cleanAddressTimerEx) clearTimeout(this.cleanAddressTimerEx);
        this.unsetError('address');

        this.cleanAddressTimerEx = setTimeout(() => {
            RestRequest.all(config.restDeliveryCleanAddress + '?filter[text]=' + event.target.value).then(result => {

                this.setState({
                    deliveryAddress: result,
                    addr_index: result[0].index,
                    addr_city: result[0].place,
                    addr_street: result[0].street,
                    addr_home: result[0].house,
                    addr_room: result[0].room,
                });
            });
        }, this.cleanAddressTimer);
    }

    handleSelectAddress(address, event) {
        this.setState({
            selectedAddress: address,
            deliveryAddress: []
        });

        this.unsetError('address');
    }

    render() {

        if (this.state.finish === true) {
            return this.finish();
        }

        return this.dashboard();
    }

    renderAddress() {
        const {errors} = this.state, {deliveryAddress} = this.state;
        let error, aria_invalid, isQualityAddress = true;

        if (typeof errors === 'object' && !Array.isArray(errors)) {
            error = <Error errors={errors['address']}/>
            aria_invalid = errors['address'] !== undefined && errors['address'] !== null;
        }

        if (deliveryAddress[0] && deliveryAddress[0]["validation-code"] === 'NOT_VALIDATED_HAS_NO_MAIN_POINTS') isQualityAddress = false;

        return <>
            <div className="checkout-form__group-row">
                <label className="checkout-form__label">
                    <div className="checkout-form__label-text">Адрес доставки</div>
                    <input aria-invalid={aria_invalid} onChange={this.handleAddress.bind(this)} type="text" name={this.modelName + "[address]"} placeholder="Например: Барнаул, ул Попова 4 кв 211" className="checkout-form__input" value={this.state.selectedAddress}/>
                    {error}
                </label>


            </div>
            {!isQualityAddress ? <div className="checkout-form-low-quality-address">Недостаточно информации, уточните адрес</div> :
                <div className="checkout-address-list">
                    {deliveryAddress.map((e, i) => {
                        const addrr = '' + e.index + (e.region ? ', ' + e.region : '') + (e.place ? ', ' + e.place : '') + (e.street ? ', ' + e.street : '') + (e.house ? ', д. ' + e.house : '') + (e.room ? ', кв ' + e.room : '');
                        return <div className="checkout-address-list__item" key={i}>
                            <div className="checkout-address-list__address">{addrr}</div>
                            <button className="checkout-address-list__select" onClick={this.handleSelectAddress.bind(this, addrr)} type="button">Выбрать</button>
                        </div>
                    })}
                </div>}


            <div className="checkout-form__group-row">
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_index != null, name: "postalcode", title: "Индекс", placeholder: "Индекс", value: this.state.addr_index}}/>
            </div>

            <div className="checkout-form__group-row">
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_city != null, name: "city", title: "Город", placeholder: "Город", value: this.state.addr_city}}/>
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_street != null, name: "street", title: "Улица", placeholder: "Улица", value: this.state.addr_street}}/>
            </div>
            <div className="checkout-form__group-row">
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_home != null, name: "number_home", title: "Номер дома", placeholder: "Номер дома", value: this.state.addr_home}}/>
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_pouch != null, name: "entrance", title: "Подъезд", placeholder: "Подъезд", value: this.state.addr_pouch}}/>
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_floor !== null, name: "floor_house", title: "Этаж", placeholder: "Этаж", value: this.state.addr_floor}}/>
                <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{isHiden: this.state.addr_room !== null, name: "number_appartament", title: "Квартира", placeholder: "Квартира", value: this.state.addr_room}}/>
            </div>
        </>;
    }

    finish() {
        const {order} = this.state;
        return <div className="checkout-success-container">
            <div className="checkout-success">
                <div className="checkout-success-header"><i className="fas fa-check-circle"/>Заказ <b>№{order.id}</b> успешно оформлен.</div>
                <div className="checkout-success-comment">В оближайшее время мы вам перезвоним</div>
                <div className="order-info">
                    <div className="order-info__row">
                        <div className="order-info__key">Время покупки</div>
                        <div className="order-info__value">{order.created}</div>
                    </div>
                    <div className="order-info__row">
                        <div className="order-info__key">Статус</div>
                        <div className="order-info__value">{order.status}</div>
                    </div>
                    <div className="order-info__row">
                        <div className="order-info__key">Сумма</div>
                        <div className="order-info__value">{order.total}</div>
                    </div>
                    <div className="order-info__row">
                        <div className="order-info__key">Доставка</div>
                        <div className="order-info__value">{order.delivery}</div>
                    </div>
                    <div className="order-info__row">
                        <div className="order-info__key">Оплата</div>
                        <div className="order-info__value">{order.payment}</div>
                    </div>
                    <div className="order-info__row">
                        <div className="order-info__key">Адрес</div>
                        <div className="order-info__value">{order.address}</div>
                    </div>
                </div>
            </div>
            <div className="checkout-success-text">
                <p>Вы можете следить за заказом из <a href="/profile/"><b>личного кабинета</b></a>. Обратите внимание, что для входа потребуется регистрация на сайте.</p>
                <p>История заказов отслеживается по номеру телефона поэтому не ошибайтесь при вводе регистрационных данных</p>
            </div>
        </div>;
    }

    dashboard() {
        let buttonLabel = parseInt(this.state.paymentId) === 1 ? 'Оформить заказ и оплатить' : 'Оформить заказ', deliveryService;

        if (parseInt(this.state.deliveryId) === 1) deliveryService = <DeliveryService/>


        return (
            <div className="page__group-row">
                <div className="page__left">
                    <form className="checkout-form" onSubmit={this.submitForm.bind(this)}>
                        <div className="checkout-form__title">Укажите способ доставки</div>

                        <Variants errors={this.state.errors} unsetError={this.unsetError.bind(this)} modelName={this.modelName} attribute="delivery_id" handlerSelect={this.handleSelectDelivery.bind(this)} models={this.state.delivery}/>

                        {/*{deliveryService}*/}


                        {/*<div className="checkout-form__title">Время и дата доставки</div>*/}
                        {/*<div className="checkout-form__group-row">*/}
                        {/*    <DateDeliveryField errors={this.state.errors}/>*/}
                        {/*    <TimeDeliveryField errors={this.state.errors}/>*/}
                        {/*</div>*/}


                        <div className="checkout-form__title">Укажите ваши данные</div>
                        <div className="checkout-form__group-row">
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "phone", title: "Ваш номер телефона*", placeholder: "Ваш номер телефона*", class: 'js-mask-ru'}}/>
                            <HtmlHelper errors={this.state.errors} unsetError={this.unsetError.bind(this)} element="input" modelName={this.modelName} options={{name: "email", title: "Ваш электронный адрес*", placeholder: "Ваш электронный адрес*"}}/>
                        </div>

                        {parseInt(this.state.deliveryId) === 3 ? '' : this.renderAddress()}


                        <label className="checkout-form__label" htmlFor="checkout-comment">
                            <HtmlHelper errors={this.state.errors} element="textarea" modelName={this.modelName} options={{name: "comment", title: "Комментарий к заказу", placeholder: "Ваши пожелания"}}/>
                        </label>


                        <div className="checkout-form__title">Укажите способ оплаты</div>
                        <Variants unsetError={this.unsetError.bind(this)} errors={this.state.errors} modelName={this.modelName} attribute="payment_id" handlerSelect={this.handleSelectPayment.bind(this)} models={this.state.payment.filter(element => !this.state.excludePayments.includes(element.id))}/>


                        {/*<div className="checkout-form__title">Промокод и бонусы</div>*/}
                        {/*<div className="checkout-form__group-row">*/}
                        {/*    <PromocodeField promocode={this.state.promocode} updatePoromocode={this.updatePoromocode.bind(this)} refreshBasket={this.refreshBasket.bind(this)}/>*/}
                        {/*    {this.state.user !== null ? <UserBonusField usedBonus={this.state.usedBonus} refreshBasket={this.refreshBasket.bind(this)} updateUsedBonus={(value) => this.setState({usedBonus: value})} accountId={this.state.user.phone}/> : <CheckoutUserBonusAuth/>}*/}
                        {/*</div>*/}

                        <div className="checkout-form__group-row" style={{alignItems: "center"}}>
                            <button type="submit" className="add-basket checkout-form__submit">{buttonLabel}</button>
                            <p className="checkout-agree-text">
                                Нажимая на кнопку «Оформить заказ», вы принимаете условия <a href="/about/agree/">Согласия на обработку персональных данных</a>
                            </p>
                        </div>

                    </form>
                </div>
                <div className="page__right">
                    <CheckoutSummary refreshBasket={this.refreshBasket.bind(this)} updateBasketItem={this.updateBasketItem.bind(this)} total={this.state.total} basket={this.state.basket}/>
                </div>
            </div>
        )
    }
}


const checkout = document.querySelector('.checkout-react');

if (checkout) {

    const userId = checkout.getAttribute('data-user');

    ReactDOM.render(<Checkout userId={userId}/>, checkout);
}
