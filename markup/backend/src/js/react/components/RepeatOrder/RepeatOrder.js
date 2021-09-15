import React from "react";
import ReactDom from 'react-dom';
import {Modal} from "react-bootstrap";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../../../../../frontend/src/js/config";
import Email from "../../../../../../frontend/src/js/tools/Email";
import RepeatOrderItems from "./RepeatOrderItems";
import RepeatNewOrderModal from "./RepeatNewOrderModal";

class RepeatOrder extends React.Component {
    constructor(props) {
        super(props);
        this.timerEx = null;
        this.timer = 1000;
        this.state = {
            show: false,
            orders: [],
        };
    }

    setShow(show) {
        this.setState({show: show});
    }

    handleClose() {
        this.setShow(false);
    }

    handleShow() {
        this.setShow(true);
    }

    handleTyping(event) {
        event.preventDefault();
        let element = event.target;
        let value = element.value;
        let _value = parseInt(value);

        if (this.timerEx) clearTimeout(this.timerEx);

        this.timerEx = setTimeout(() => {
            //is order id
            if (Number.isInteger(_value) && _value.toString().length < 10) {
                RestRequest.one(config.restOrder, value, '?expand=items').then(data => {
                    let arData = [];
                    arData.push(data);
                    this.setState({orders: arData});
                });
            }

            //is phone
            if (Number.isInteger(_value) && _value.toString().length === 11) {
                RestRequest.all(config.restOrder + '?expand=items&OrderSearchForm[phone]=' + value).then(data => {
                    this.setState({orders: data});
                });
            }

            //is email
            if (Email.validateEmail(value)) {
                RestRequest.one(config.restOrder, value + '?expand=items&OrderSearchForm[email]=' + value).then(data => {
                    this.setState({orders: data});
                });
            }
        }, this.timer);
    }

    render() {

        const {show, orders} = this.state;

        return (
            <>
                <a href="#" type="button" className="btn-main" onClick={this.handleShow.bind(this)}>Повторить заказ</a>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Повторить заказ</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>


                        <div className="admin-repeat-order">
                            <input className="admin-repeat-order__input" type="text" placeholder="ID заказа или Номер телефона клиента или Email клиента" onChange={this.handleTyping.bind(this)}/>

                            <div className="repeat-order-list">
                                {orders.map((el, index) => {
                                    return <div key={index} className="repeat-order-list-item">
                                        <div className="repeat-order-list-item-row">

                                            <div className="repeat-order-list-item__name">Заказ #{el.id}</div>

                                            <div className="repeat-order-list-item__phone">{el.phone}</div>

                                            <div className="repeat-order-list-item__email">{el.email}</div>

                                            <RepeatNewOrderModal order={el}/>
                                        </div>
                                        <div className="repeat-order-list-item-row">
                                            <RepeatOrderItems items={el.items}/>
                                        </div>
                                    </div>
                                })}
                            </div>
                        </div>
                    </Modal.Body>
                </Modal>
            </>
        );
    }
}

let el = document.querySelector('.repeat-order-react');
if (el) ReactDom.render(<RepeatOrder/>, el);
