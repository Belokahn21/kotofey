import React from 'react';
import {Modal} from "react-bootstrap";

class ModalNotify extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: true
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

    render() {
        const {show} = this.state;
        return <Modal show={show} onHide={this.handleClose.bind(this)}>
            <Modal.Header closeButton>
                <Modal.Title>Уведомить о поступлении товара</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                12121221
            </Modal.Body>
        </Modal>
    }
}

export default ModalNotify;