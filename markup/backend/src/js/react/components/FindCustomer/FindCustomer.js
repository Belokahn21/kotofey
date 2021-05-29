import React from "react";
import ReactDom from "react-dom";
import {Modal} from "react-bootstrap";
import FindProductForm from "../FindProduct/FindProductForm";
import FindCustomerForm from "./FindCustomerForm";
import FindCustomerLast from "./FindCustomerLast";

class FindCustomer extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            customer: null,
            show: false
        }
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

    handleSelectCustomer(customer, event) {
        let currentElement = event.target;

        let parentInput = document.querySelector('.load-customer-info__pid');
        if (parentInput && parentInput.value.length === 0) parentInput.value = customer.phone;


        Object.keys(customer.cross).map(key => {
            let element = document.querySelector('#order-' + key)
            if (element) element.value = customer.cross[key];
        })

    }

    render() {
        const {options} = this.props;
        const {customer, show} = this.state;
        return (
            <div>
                <div className="form-finds__setup" onClick={this.handleShow.bind(this)}>+</div>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Найти карточку покупателя</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <FindCustomerForm handleSelectCustomer={this.handleSelectCustomer} />
                        <FindCustomerLast handleSelectCustomer={this.handleSelectCustomer} />
                    </Modal.Body>
                </Modal>
            </div>
        );
    }

}

let elements = document.querySelectorAll('.find-customer-react');
if (elements) {
    elements.forEach(el => {
        ReactDom.render(<FindCustomer options={el.getAttribute('data-options')}/>, el);
    })
}