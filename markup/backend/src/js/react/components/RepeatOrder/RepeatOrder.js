import React from "react";
import ReactDom from 'react-dom';
import {Modal} from "react-bootstrap";

class RepeatOrder extends React.Component {
    constructor(props) {
        super(props);
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

    render() {

        const {show} = this.state;

        return (
            <>
                <button type="button" className="btn-main" onClick={this.handleShow.bind(this)}>Повторить заказ</button>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Найти ID товара</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        повторяем заказ)
                    </Modal.Body>
                </Modal>
            </>
        );
    }
}

let el = document.querySelector('.repeat-order-react');
if (el) ReactDom.render(<RepeatOrder/>, el);
