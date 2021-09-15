import React from "react";
import Price from "../../../../../../frontend/src/js/tools/Price";
import Button from "../FindProduct/Button";

class RepeatForm extends React.Component {

    constructor(props) {
        super(props);
    }

    handleSubmitForm(e) {
        e.preventDefault();

        alert();
    }

    render() {
        const {order} = this.props;
        return (
            <form className="repeat-order-form" onSubmit={this.handleSubmitForm.bind(this)}>

                <div className="row">
                    <div className="col-sm-6">
                        <label className="repeat-order-form-label">
                            <div className="repeat-order-form-title">Email</div>
                            <input className="repeat-order-form-input" type="text" placeholder="email" defaultValue={order.email}/>
                        </label>
                    </div>
                    <div className="col-sm-6">
                        <label className="repeat-order-form-label">
                            <div className="repeat-order-form-title">Телефон</div>
                            <input className="repeat-order-form-input" type="text" placeholder="phone" defaultValue={order.phone}/>
                        </label>
                    </div>
                </div>

                <label className="repeat-order-form-label">
                    <div className="repeat-order-form-title">Статус</div>
                    <input className="repeat-order-form-input" type="text" placeholder="status" defaultValue={order.status}/>
                </label>

                <div className="row">
                    <div className="col-sm-6">
                        <label className="repeat-order-form-label">
                            <div className="repeat-order-form-title">Доставка</div>
                            <input className="repeat-order-form-input" type="text" placeholder="delivery" defaultValue={order.delivery_id}/>
                        </label>
                    </div>
                    <div className="col-sm-6">
                        <label className="repeat-order-form-label">
                            <div className="repeat-order-form-title">Оплата</div>
                            <input className="repeat-order-form-input" type="text" placeholder="payment" defaultValue={order.payment_id}/>
                        </label>
                    </div>
                </div>


                <div className="list-finds">
                    {order.items.map((el, index) => {
                        return <div className="list-finds__item" key={index}>
                            <a href={el.imageUrl} data-lightbox="roadtrip"><img src={el.imageUrl} className="list-finds__image"/></a>
                            <a href={el.backendHref} target="_blank" className="list-finds__link">{el.name}</a>
                            <div className="list-finds-data">
                                <div className="list-finds-data__row">
                                    <div className="list-finds-data__key">Цена</div>
                                    <div className="list-finds-data__value">{Price.format(el.price)}</div>
                                </div>
                                {!el.discount_price ? '' :
                                    <div className="list-finds-data__row">
                                        <div className="list-finds-data__key">Со скидкой</div>
                                        <div className="list-finds-data__value">{Price.format(el.discount_price)}</div>
                                    </div>}
                                <div className="list-finds-data__row">
                                    <div className="list-finds-data__key">Кол-во</div>
                                    <div className="list-finds-data__value">{el.count}</div>
                                </div>
                            </div>
                            <button type="button" className="list-finds__setup">J</button>
                        </div>
                    })}
                </div>

                <button type="submit" className="repeat-order-form-submit">Отправить</button>
            </form>
        );
    }

}

export default RepeatForm;