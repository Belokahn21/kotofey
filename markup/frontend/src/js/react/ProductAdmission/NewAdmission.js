import React from 'react';
import {Modal} from 'react-bootstrap';
import FormAdmission from "./FormAdmission";
import Inputmask from "maskedinput";

class NewAdmission extends React.Component {
    constructor() {
        super();

        this.state = {
            show: false
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

    onShowModal() {
        let im = new Inputmask("+7 (999) 999 99-99", {placeholder: "+7 (___) ___ __ __"});
        im.mask(document.querySelector(".js-mask-ru"));
    }

    render() {
        const {show} = this.state;
        const {handleSubmitForm,product_id} = this.props;
        return <>
            <div className="product-status__notify" onClick={this.handleShow.bind(this)}>Уведомить о поступлении</div>

            <Modal show={show} onShow={this.onShowModal.bind(this)} onHide={this.handleClose.bind(this)}>
                <Modal.Header closeButton>
                    <Modal.Title>Уведомить о поступлении товара</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <FormAdmission product_id={product_id} handleSubmitForm={handleSubmitForm}/>
                </Modal.Body>
            </Modal>
        </>
    }
}

export default NewAdmission;