import React from "react";
import Price from "../../../../../../frontend/src/js/tools/Price";
import Button from "../FindProduct/Button";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../../../../../frontend/src/js/config";

class RepeatForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            status: [],
            delivery: [],
            payment: [],
        };
    }

    handleSubmitForm(e) {
        e.preventDefault();

        let body = new FormData();
        body.append('order_id', this.props.order.id);

        RestRequest.post(config.restOrderRepeat, {
            body: body
        }).then(data => {
            console.log(data);
        });
    }

    componentDidMount() {
        this.loadStatus();
        this.loadPayment();
        this.loadDelivery();
    }

    loadStatus() {
        RestRequest.all(config.restOrderStatus).then(data => {
            this.setState({status: data});
        });
    }

    loadDelivery() {
        RestRequest.all(config.restDelivery).then(data => {
            this.setState({delivery: data});
        });
    }

    loadPayment() {
        RestRequest.all(config.restPayment).then(data => {
            this.setState({payment: data});
        });
    }

    render() {
        const {order} = this.props;
        const {status, payment, delivery} = this.state;
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
                    <select className="repeat-order-form-select">
                        {status.map((el, index) => {
                            return <option key={index} selected={order.status === el.id} defaultValue={el.id}>{el.name}</option>
                        })}
                    </select>
                </label>

                <div className="row">
                    <div className="col-sm-6">
                        <label className="repeat-order-form-label">
                            <div className="repeat-order-form-title">Доставка</div>
                            <select className="repeat-order-form-select">
                                {delivery.map((el, index) => {
                                    return <option key={index} selected={order.delivery_id === el.id} defaultValue={el.id}>{el.name}</option>
                                })}
                            </select>
                        </label>
                    </div>
                    <div className="col-sm-6">
                        <label className="repeat-order-form-label">
                            <div className="repeat-order-form-title">Оплата</div>
                            <select className="repeat-order-form-select">
                                {payment.map((el, index) => {
                                    return <option key={index} selected={order.payment_id === el.id} defaultValue={el.id}>{el.name}</option>
                                })}
                            </select>
                        </label>
                    </div>
                </div>

                <button type="submit" className="repeat-order-form-submit">Отправить</button>
            </form>
        );
    }

}

export default RepeatForm;