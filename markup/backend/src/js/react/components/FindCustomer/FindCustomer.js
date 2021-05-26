import React from "react";
import ReactDom from "react-dom";
import {Modal} from "react-bootstrap";
import FindProductForm from "../FindProduct/FindProductForm";
import FindCustomerForm from "./FindCustomerForm";

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
                        <FindCustomerForm />
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