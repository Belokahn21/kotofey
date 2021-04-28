import React from 'react';
import ReactDom from "react-dom";
import {Modal, Button} from 'react-bootstrap';
import RestRequest from "../../tools/RestRequest";
import config from '../../config';
import HtmlHelper from "../checkout/html/HtmlHelper";
import Inputmask from "maskedinput";

class BuyOneClick extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            show: false,
            order: null,
            product: {},
        };
    }

    componentDidMount() {
        this.loadProduct();
    }

    loadProduct() {
        RestRequest.one(config.restCatalog, this.props.product_id, '?expand=imageUrl').then(data => {
            this.setState({product: data});
        });
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

    handleSubmitForm(event) {
        event.preventDefault();
        let form = event.target;
        RestRequest.post(config.restFastOrder, {
            body: new FormData(form)
        }).then(data => {
            if (parseInt(data.status) === 200) {
                this.setState({order: data})
            }
        });
    }

    renderFinish() {
        return <div className="buy-one-click__success">
            Заказ успешно оформлен. В ближайшее время с вами свяжется оператор для уточнения деталей заказа. Спасибо за покупку!
        </div>
    }

    renderForm() {
        const {product} = this.state;
        return <form className="buy-one-click-form" onSubmit={this.handleSubmitForm.bind(this)}>
            <label className="checkout-form__label" htmlFor="">
                <div className="checkout-form__label-text">Ваш номер телефона</div>
                <input className="checkout-form__input js-mask-ru" name="Order[phone]" type="text" placeholder='Ваш номер телефона'/>
            </label>

            <label className="checkout-form__label" htmlFor="">
                <div className="checkout-form__label-text">E-mail</div>
                <input className="checkout-form__input" name="Order[email]" type="text" placeholder='Ваш электронный адрес'/>
            </label>

            <input className="checkout-form__input" name="OrdersItems[product_id]" type="hidden" value={product.id}/>
            <input className="checkout-form__input" name="OrdersItems[count]" type="hidden" value="1"/>

            <img alt={product.name} title={product.name} className="buy-one-click__image" src={product.imageUrl}/>


            <button type="submit" className="btn-main">Сделать заказ</button>
        </form>;
    }

    modalOnShow() {
        let russsianPhone = document.querySelector(".js-mask-ru");
        if (russsianPhone) {
            let im = new Inputmask("+7 (999) 999 99-99", {placeholder: "+7 (___) ___ __ __"});
            im.mask(russsianPhone);
        }
    }

    render() {
        const {show, product, order} = this.state;
        return <>
            <a className="one-click-buy" onClick={this.handleShow.bind(this)}><span>В один клик</span></a>

            <Modal show={show} onHide={this.handleClose.bind(this)} onShow={this.modalOnShow.bind(this)}>
                <Modal.Header closeButton>
                    <Modal.Title>
                        <div>Купить в 1 клик</div>
                        <div className="buy-one-click__product-title">{product.name}</div>
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>

                    {order === null ? this.renderForm() : this.renderFinish()}

                </Modal.Body>
            </Modal>
        </>
    }
}


let elements = document.querySelectorAll('.buy-one-click-react');
if (elements) {


    elements.forEach(el => {
        let product_id = el.getAttribute('data-product-id');
        if (product_id) {
            ReactDom.render(<BuyOneClick product_id={product_id}/>, el);
        } else {
            ReactDom.render(<BuyOneClick/>, el);
        }
    });
}
